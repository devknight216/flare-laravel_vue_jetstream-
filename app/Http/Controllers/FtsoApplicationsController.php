<?php

namespace App\Http\Controllers;

use Imagick;
use Notification;
use App\Models\Ftso;

use App\Models\User;
use App\Models\FtsoOwner;
use Illuminate\Http\Request;
use App\Models\FtsoApplication;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Meema\CloudFront\Jobs\InvalidateCache;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use App\Notifications\ProviderApplicationSubmitted;
use App\Notifications\ProviderUpdateApplicationResult;

class FtsoApplicationsController extends Controller
{
    public function submitApplication(Request $request)
    {
        // *********************
        // ** Data Validation **
        // *********************

        $data = json_decode($request->data, true);

        $rules = [
            'name' => ['required', 'max:65'],
            'admin_email' => ['required', 'email', 'max:65'],
            'website_url' => ['required', 'url', 'unique:ftsos', 'max:120'],
            'feature_video' => ['nullable', 'url', 'max:165'],
            'description' => ['string', 'max:156'],
            'extended_description' => ['string', 'max:800'],
            'additional_comments' => ['string', 'max:1500'],
            'ftso_id' => ['exists:ftsos'],
            'type' => ['in:register,update']

        ];

        if ($request->input('type') == 'register') {
            $rules['website_url'] = ['required', 'url', 'unique:ftsos', 'max:120'];
        } else {
            $rules['website_url'] = ['required', 'url', 'max:120'];
        }

        $validatedRules = $rules;

        $validator = Validator::make($data, $validatedRules);
        if (!$validator->passes()) {
            return [
                'error' => true,
                'errors' => $validator->errors()->all()
            ];
        }

        $data = json_decode($request->data);



        // ********************************
        // ** Check & Upload Files to S3 **
        // ********************************
        $image_name_base = str_replace('.', '-', parse_url($data->website_url, PHP_URL_HOST));
        $random = rand(100000, 999999);

        if (filter_var($request->input('logo'), FILTER_VALIDATE_URL)) {
            $logo_url = $request->input('logo');
        } elseif ($request->file('logo')->isValid()) {
            // Logo Image Upload
            $store_logo_path = 'flare/ftso/applications/' . $image_name_base . "-logo-{$random}." . $request->file('logo')->extension();
            Storage::disk('s3')->put($store_logo_path, file_get_contents($request->file('logo')), 'public');
            $logo_url = Storage::disk('s3')->url($store_logo_path);
            $logo_url = str_replace('https://avaxbucket.s3.amazonaws.com', 'https://cdn.flaremetrics.io', $logo_url);
        }


        if (filter_var($request->input('emblem'), FILTER_VALIDATE_URL)) {
            $emblem_url = $request->input('emblem');
        } elseif ($request->file('emblem')->isValid()) {
            // Emblem Image Upload
            $store_emblem_path = 'flare/ftso/applications/' . $image_name_base . "-emblem-{$random}." . $request->file('emblem')->extension();
            Storage::disk('s3')->put($store_emblem_path, file_get_contents($request->file('emblem')), 'public');
            $emblem_url = Storage::disk('s3')->url($store_emblem_path);
            $emblem_url = str_replace('https://avaxbucket.s3.amazonaws.com', 'https://cdn.flaremetrics.io', $emblem_url);
        }

        // ********************
        // ** Insert into DB **
        // ********************
        $ftso = FtsoApplication::create([
            'name' => $data->name,
            'logo' =>  $logo_url,
            'emblem' =>  $emblem_url,
            'description' => $data->description,
            'extended_description' => $data->extended_description,
            'website_url' => $data->website_url,
            'info' => $data->info,
            'socials' => $data->socials,
            'admin_email' => $data->admin_email,
            'status' => 'pending',
            'type' => $data->type,
            'feature_video' => $data->feature_video,
            'additional_comments' => $data->additional_comments,
            'ftsos_id' => $data->ftsos_id ?? null,
            'user_id' => Auth::id()
        ]);

        Notification::route('mail', Auth::user()->email)
            ->notify(new ProviderApplicationSubmitted());

        return [
            'error' => false,
            'message' => $ftso
        ];
    }

    public function getApplications(Request $request)
    {
        $ftso = Ftso::where('code', $request->input('code'))->first();
        if (!FtsoOwner::isOwner($ftso, Auth::user())) {
            return Redirect('/');
        }
        return $ftso->applications()->select('type', 'created_at', 'status')->offset(0)->limit(4)->get();
    }
    public function getApplicationsPaginate(Request $request)
    {
        $type = $request->input('show_type') == 'register' || $request->input('show_type') == 'update' ? true : false;
        $applications = FtsoApplication::when($type, function ($query) use ($request) {
            return $query->where('type', $request->input('show_type'));
        })->when($request->input('pending_only'), function ($query) {
            return $query->where('status', 'pending');
        })->orderBy('id', 'desc')->paginate(10);

        return $applications;
    }

    public function createProviderFromApplication(Request $request)
    {
        // *********************
        // ** Data Validation **
        // *********************

        $data = json_decode($request->data, true);

        $rules = [
            'name' => ['required', 'max:65'],
            'code' => ['required', 'max:6'],
            'admin_email' => ['required', 'email', 'max:65'],
            'website_url' => ['required', 'url', 'unique:ftsos', 'max:120'],
            'feature_video' => ['nullable', 'url', 'max:165'],
            'description' => ['string', 'max:156'],
            'extended_description' => ['string', 'max:800'],
            'additional_comments' => ['string', 'max:1500'],
            'application_id' => ['exists:ftso_applications,id'],
            'type' => ['in:register,update'],
            'outcome.status' => ['in:approve']

        ];

        if ($request->input('type') == 'register') {
            $rules['website_url'] = ['required', 'url', 'unique:ftsos', 'max:120'];
        } else {
            $rules['website_url'] = ['required', 'url', 'max:120'];
        }



        $validatedRules = $rules;

        $validator = Validator::make($data, $validatedRules);
        if (!$validator->passes()) {
            return [
                'error' => true,
                'errors' => $validator->errors()->all()
            ];
        }

        $data = json_decode($request->data);

        $application = FtsoApplication::find($data->application_id);

        if (
            $application->status == 'approved'
        ) {
            return ['error' => true, 'message' => 'This application has aleady been approved.'];
        }

        // ********************************
        // ** Check & Upload Files to S3 **
        // ********************************
        $image_name_base = strtolower(str_replace(' ', '', $data->name));

        // Logo Image Upload
        if (filter_var($request->input('logo'), FILTER_VALIDATE_URL)) {
            $extension = pathinfo($request->input('logo'))["extension"];
            $path = "flare/ftso/{$image_name_base}-logo.{$extension}";
            Storage::disk('s3')->put($path, file_get_contents($request->input('logo')), 'public');
            $logo_url = Storage::disk('s3')->url($path);
            $logo_url = str_replace(env('S3_BUCKET_URL'), env('CDN_URL'), $logo_url);
        } elseif ($request->file('logo')->isValid()) {
            $store_logo_path = 'flare/ftso/' . $image_name_base . '-logo.' . $request->file('logo')->extension();
            Storage::disk('s3')->put($store_logo_path, file_get_contents($request->file('logo')), 'public');
            $logo_url = Storage::disk('s3')->url($store_logo_path);
            $logo_url = str_replace(env('S3_BUCKET_URL'), env('CDN_URL'), $logo_url);
        }

        // Emblem Image Upload
        if ($request->file('emblem')->isValid()) {
            $filename     = $image_name_base . '@256.' . $request->file('emblem')->extension();
            $filename128  = $image_name_base . '@128.' . $request->file('emblem')->extension();
            $filename64   = $image_name_base . '@64.' . $request->file('emblem')->extension();

            $store_emblem_path      = 'flare/ftso/emblem/' . $filename;
            $store_emblem_path128   = 'flare/ftso/emblem/' . $filename128;
            $store_emblem_path64    = 'flare/ftso/emblem/' . $filename64;



            $image = $request->file('emblem');

            // Create Tmp directory for storage
            $tmp_dir = (new TemporaryDirectory())
                ->name($image_name_base)
                ->force()
                ->create();

            // Set Image to uploaded file
            $img = Image::make($image->path());

            // 256x256 Image
            $img->resize(256, 256, function ($const) {
                $const->aspectRatio();
            })->save($tmp_dir->path() . '/' . $filename);

            // 128x128 Image
            $img->resize(128, 128, function ($const) {
                $const->aspectRatio();
            })->save($tmp_dir->path() . '/' . $filename128);

            // 64x64 Image
            $img->resize(64, 64, function ($const) {
                $const->aspectRatio();
            })->save($tmp_dir->path() . '/' . $filename64);


            Storage::disk('s3')->put($store_emblem_path, file_get_contents($tmp_dir->path("/{$filename}")), 'public');
            Storage::disk('s3')->put($store_emblem_path128, file_get_contents($tmp_dir->path("/{$filename128}")), 'public');
            Storage::disk('s3')->put($store_emblem_path64, file_get_contents($tmp_dir->path("/{$filename64}")), 'public');

            $tmp_dir->delete();


            $emblem_url = Storage::disk('s3')->url($store_emblem_path64);
            $emblem_url = str_replace(env('S3_BUCKET_URL'), env('CDN_URL'), $emblem_url);
        } else {
            return ['error' => true, 'message' => 'Image failed upload.'];
        }

        // ********************
        // ** Insert into DB **
        // ********************
        $ftso = Ftso::create([
            'name' => $data->name,
            'code' => $data->code,
            'logo' =>  urldecode($logo_url),
            'emblem' =>  urldecode($emblem_url),
            'description' => $data->description,
            'extended_description' => $data->extended_description,
            'website' => parse_url($data->website_url)['host'],
            'website_url' => $data->website_url,
            'info' => $data->info,
            'socials' => $data->socials,
            'admin_email' => $data->admin_email,
            'feature_video' => $data->feature_video,
            'verified' => true,
        ]);

        $application->status = 'approved';
        $application->ftsos_id = $ftso->id;
        $application->admin_notes = $data->outcome->notes;
        $application->save();

        Notification::route('mail', User::find($application->user_id)->email)
            ->notify(new ProviderUpdateApplicationResult($application));

        $owner = new FtsoOwner();
        $owner->user_id = $application->user_id;
        $owner->ftsos_id = $ftso->id;
        $owner->save();




        return [
            'error' => false,
            'message' => [
                'application' => $application,
                'ftso' => $ftso
            ]
        ];
    }
    public function updateProviderFromApplication(Request $request)
    {
        // *********************
        // ** Data Validation **
        // *********************

        $data = json_decode($request->data, true);

        $rules = [
            'name' => ['required', 'max:65'],
            'website_url' => ['required', 'url', 'unique:ftsos', 'max:120'],
            'feature_video' => ['nullable', 'url', 'max:165'],
            'description' => ['string', 'max:156'],
            'extended_description' => ['string', 'max:800'],
            'additional_comments' => ['string', 'max:1500'],
            'ftso_id' => ['exists:ftsos'],
            'application_id' => ['exists:ftso_applications,id'],
            'type' => ['in:register,update'],
            'outcome.status' => ['in:approve']

        ];

        if ($request->input('type') == 'register') {
            $rules['website_url'] = ['required', 'url', 'unique:ftsos', 'max:120'];
        } else {
            $rules['website_url'] = ['required', 'url', 'max:120'];
        }


        $validatedRules = $rules;

        $validator = Validator::make($data, $validatedRules);
        if (!$validator->passes()) {
            return [
                'error' => true,
                'errors' => $validator->errors()->all()
            ];
        }

        $data = json_decode($request->data);

        $application = FtsoApplication::find($data->application_id);

        if ($application->status == 'approved') {
            return ['error' => true, 'message' => 'This application has aleady been approved.'];
        }

        // ********************************
        // ** Check & Upload Files to S3 **
        // ********************************
        $image_name_base = strtolower(str_replace(' ', '', $data->name));

        // Logo Image Upload
        if (filter_var($request->input('logo'), FILTER_VALIDATE_URL)) {
            $extension = pathinfo($request->input('logo'))["extension"];
            $path = "flare/ftso/{$image_name_base}-logo.{$extension}";
            Storage::disk('s3')->put($path, file_get_contents($request->input('logo')), 'public');
            $logo_url = Storage::disk('s3')->url($path);
            dispatch(new InvalidateCache('/' . $path));
            $logo_url = str_replace(env('S3_BUCKET_URL'), env('CDN_URL'), $logo_url);
        } elseif ($request->file('logo')->isValid()) {
            $store_logo_path = 'flare/ftso/' . $image_name_base . '-logo.' . $request->file('logo')->extension();
            Storage::disk('s3')->put($store_logo_path, file_get_contents($request->file('logo')), 'public');
            $logo_url = Storage::disk('s3')->url($store_logo_path);
            dispatch(new InvalidateCache('/' . $store_logo_path));
            $logo_url = str_replace(env('S3_BUCKET_URL'), env('CDN_URL'), $logo_url);
        }

        // Emblem Image Upload
        if ($request->file('emblem')->isValid()) {
            $filename     = $image_name_base . '@256.' . $request->file('emblem')->extension();
            $filename128  = $image_name_base . '@128.' . $request->file('emblem')->extension();
            $filename64   = $image_name_base . '@64.'  . $request->file('emblem')->extension();

            $store_emblem_path      = 'flare/ftso/emblem/' . $filename;
            $store_emblem_path128   = 'flare/ftso/emblem/' . $filename128;
            $store_emblem_path64    = 'flare/ftso/emblem/' . $filename64;

            $image = $request->file('emblem');

            // Create Tmp directory for storage
            $tmp_dir = (new TemporaryDirectory())
                ->name($image_name_base)
                ->force()
                ->create();

            // Set Image to uploaded file
            $img = Image::make($image->path());

            // 256x256 Image
            $img->resize(256, 256, function ($const) {
                $const->aspectRatio();
            })->save($tmp_dir->path() . '/' . $filename);

            // 128x128 Image
            $img->resize(128, 128, function ($const) {
                $const->aspectRatio();
            })->save($tmp_dir->path() . '/' . $filename128);

            // 64x64 Image
            $img->resize(64, 64, function ($const) {
                $const->aspectRatio();
            })->save($tmp_dir->path() . '/' . $filename64);


            Storage::disk('s3')->put($store_emblem_path,    file_get_contents($tmp_dir->path("/{$filename}")),    'public');
            Storage::disk('s3')->put($store_emblem_path128, file_get_contents($tmp_dir->path("/{$filename128}")), 'public');
            Storage::disk('s3')->put($store_emblem_path64,  file_get_contents($tmp_dir->path("/{$filename64}")),  'public');

            $tmp_dir->delete();

            $emblem_url = Storage::disk('s3')->url($store_emblem_path64);
            dispatch(new InvalidateCache('/' . $store_emblem_path));
            dispatch(new InvalidateCache('/' . $store_emblem_path128));
            dispatch(new InvalidateCache('/' . $store_emblem_path64));
            $emblem_url = str_replace(env('S3_BUCKET_URL'), env('CDN_URL'), $emblem_url);
        } else {
            return ['error' => true, 'message' => 'Image failed upload.'];
        }

        // ********************
        // ** Insert into DB **
        // ********************
        $ftso = Ftso::find($data->ftsos_id);
        $ftso->update([
            'name' => $data->name,
            'logo' =>  urldecode($logo_url),
            'emblem' =>  urldecode($emblem_url),
            'description' => $data->description,
            'extended_description' => $data->extended_description,
            'website' => parse_url($data->website_url)['host'],
            'website_url' => $data->website_url,
            'info' => $data->info,
            'socials' => $data->socials,
            'feature_video' => $data->feature_video,
            'verified' => true,
        ]);

        $application->status = 'approved';
        $application->ftsos_id = $ftso->id;
        $application->admin_notes = $data->outcome->notes;
        $application->save();

        Notification::route('mail', User::find($application->user_id)->email)
            ->notify(new ProviderUpdateApplicationResult($application));

        return [
            'error' => false,
            'message' => [
                'application' => $application,
                'ftso' => $ftso
            ]
        ];
    }
    public function rejectApplication(Request $request)
    {
        $outcome = $request->input('outcome');
        $application = FtsoApplication::find($request->input('application_id'));
        $application->status = 'rejected';
        $application->admin_notes = $outcome['notes'];
        $application->save();

        Notification::route('mail', User::find($application->user_id)->email)
            ->notify(new ProviderUpdateApplicationResult($application));

        return [
            'error' => false,
            'message' => "Rejected application."
        ];
    }
}