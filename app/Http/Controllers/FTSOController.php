<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ftso;
use App\Models\ProviderPool;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;



class FTSOController extends Controller
{

    public function approveProviderPool(Request $request)
    {
        $pool = ProviderPool::find($request->pool_id);
        $pool->approved = true;
        $pool->save();

        return [
            'error' => false
        ];
    }
    public function createProviderPool(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:6', 'max:26'],
                'description' => ['required', 'min:26', 'max:255'],
                'network' => ['required', 'in:songbird,coston,flare'],
                'address' => ['required', 'min:40', 'max:255'],
                'provider' => ['required', 'exists:ftsos,code'],
            ]
        );
        if (!$validator->passes()) {
            return [
                'error' => true,
                'errors' => $validator->errors()->first()
            ];
        }

        $provider = Ftso::where('code', $request->input('provider'))->first();

        $pool = new ProviderPool;
        $pool->name = $request->input('name');
        $pool->description = $request->input('description');
        $pool->network = $request->input('network');
        $pool->address = $request->input('address');
        $pool->ftso_id = $provider->id;
        $pool->save();

        return [
            'error' => false,
            'pools' => $pool
        ];
    }
    public function getProviderPools(Request $request)
    {
        $provider = Ftso::where('code', $request->input('code'))->orWhere('uid', $request->input('code'))->first();
        if (!$provider) {
            return [
                'error' => true,
                'message' => 'No pools found for provider.'
            ];
        }

        return [
            'error' => false,
            'pools' => $provider->pools
        ];
    }
    public function getProviderPoolsPaginate(Request $request)
    {

        $pools = ProviderPool::where('approved', false)->paginate(5);

        return $pools;
    }
    public function listFTSO(Request $request)
    {


        $ftso = new Ftso;
        if ($request->input('hide_unverified') == 'true') {
            return $ftso->makeHidden(['admin_email'])->where('name', 'like', '%' . $request->input('q') . '%')->where('verified', true)->get();
        }
        return $ftso->makeHidden(['admin_email'])->where('name', 'like', '%' . $request->input('q') . '%')->orderBy('verified', 'desc')->orderBy('id', 'asc')->get();
    }
    public function singleFTSO($id)
    {
        if (strlen($id) > 6) {
            return Ftso::where('uid', $id)->first();
        } else {
            return Ftso::where('code', $id)->first();
        }
        abort(404);
    }

    public function listAllFTSO()
    {
        return Ftso::all()->makeVisible(['admin_email']);
    }
    public function createFTSO(Request $request)
    {
        if ($request->ip() !==  '110.141.212.158' && !env('APP_DEBUG')) return ['message' => 'unauthenticated.'];


        // *********************
        // ** Data Validation **
        // *********************

        $data = json_decode($request->data, true);
        $validatedRules = [
            'name' => ['required', 'unique:ftsos', 'max:65'],
            'code' => ['string', 'unique:ftsos', 'max:6'],
            'admin_email' => ['required', 'email', 'unique:ftsos', 'max:65'],
            'website_url' => ['required', 'url', 'unique:ftsos', 'max:120'],
            'website' => ['required', 'string', 'unique:ftsos', 'max:120'],
            'feature_video' => ['nullable', 'url', 'max:165'],
            'description' => ['string', 'max:650'],
            'extended_description' => ['string', 'max:650'],
            'site_description' => ['string', 'max:1500'],

        ];

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

        if (
            $request->file('logo')->isValid() &&
            $request->file('emblem')->isValid() &&
            $request->file('meta_image')->isValid()
        ) {
            $image_name_base = str_replace('.', '-', $data->website);

            // Logo Image Upload
            $store_logo_path = 'flare/ftso/' . $image_name_base . '-logo.' . $request->file('logo')->extension();
            Storage::disk('s3')->put($store_logo_path, file_get_contents($request->file('logo')), 'public');
            $logo_url = Storage::disk('s3')->url($store_logo_path);

            // Emblem Image Upload
            $store_emblem_path = 'flare/ftso/' . $image_name_base . '-emblem.' . $request->file('emblem')->extension();
            Storage::disk('s3')->put($store_emblem_path, file_get_contents($request->file('emblem')), 'public');
            $emblem_url = Storage::disk('s3')->url($store_emblem_path);

            // Meta Image Upload
            $store_metaimage_path = 'flare/ftso/meta/' . $image_name_base . '-meta-image.' . $request->file('meta_image')->extension();
            Storage::disk('s3')->put($store_metaimage_path, file_get_contents($request->file('meta_image')), 'public');
            $meta_image_url = Storage::disk('s3')->url($store_metaimage_path);
        }

        $urls = [
            'logo' => $logo_url,
            'emblem' => $emblem_url,
            'meta-image' => $meta_image_url
        ];

        // ***********************************
        // ** Parse S3 URLs to CDN addresss **
        // ***********************************

        foreach ($urls as $type => $url) {
            $urls[$type] = str_replace('https://avaxbucket.s3.amazonaws.com', 'https://cdn.flaremetrics.io', $url);
        }

        // ********************
        // ** Insert into DB **
        // ********************

        $ftso = Ftso::create([
            'name' => $data->name,
            'code' => $data->code,
            'logo' => $urls['logo'],
            'emblem' => $urls['emblem'],
            'meta_image' => $urls['meta-image'],
            'description' => $data->description,
            'extended_description' => $data->extended_description,
            'website' => $data->website,
            'website_url' => $data->website_url,
            'info' => $data->info,
            'socials' => $data->socials,
            'admin_email' => $data->admin_email,
            'verified' => $data->verified,
            'feature_video' => $data->feature_video,
            'site_description' => $data->site_description,
        ]);



        return [
            'error' => false,
            'message' => $ftso
        ];
    }
    public function updateFTSO(Request $request)
    {

        if ($request->ip() !==  '110.141.212.158' && !env('APP_DEBUG')) return ['message' => 'unauthenticated.'];

        // *********************
        // ** Data Validation **
        // *********************


        $data = json_decode($request->data, true);
        $validatedRules = [
            'name' => ['required',  'max:65'],
            'code' => ['string',  'max:6'],
            'admin_email' => ['required', 'email',  'max:65'],
            'website_url' => ['required', 'url',  'max:120'],
            'website' => ['required', 'string',  'max:120'],
            'feature_video' => ['nullable', 'string', 'max:165'],
            'description' => ['string', 'max:650'],
            'extended_description' => ['string', 'max:650'],
            'site_description' => ['nullable', 'string', 'max:1500'],

        ];

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


        $image_name_base = str_replace('.', '-', $data->website);

        // Logo Image Upload
        if (
            $data->logo_updated &&
            $request->file('logo')->isValid()
        ) {
            $store_logo_path = 'flare/ftso/' . $image_name_base . '-logo.' . $request->file('logo')->extension();
            Storage::disk('s3')->put($store_logo_path, file_get_contents($request->file('logo')), 'public');
            $logo_url = Storage::disk('s3')->url($store_logo_path);
        }

        if (
            $data->emblem_updated &&
            $request->file('emblem')->isValid()
        ) {
            // Emblem Image Upload
            $store_emblem_path = 'flare/ftso/' . $image_name_base . '-emblem.' . $request->file('emblem')->extension();
            Storage::disk('s3')->put($store_emblem_path, file_get_contents($request->file('emblem')), 'public');
            $emblem_url = Storage::disk('s3')->url($store_emblem_path);
        }

        if ($data->meta_image_updated && $request->file('meta_image')->isValid()) {
            // Meta Image Upload
            $store_metaimage_path = 'flare/ftso/meta/' . $image_name_base . '-meta-image.' . $request->file('meta_image')->extension();
            Storage::disk('s3')->put($store_metaimage_path, file_get_contents($request->file('meta_image')), 'public');
            $meta_image_url = Storage::disk('s3')->url($store_metaimage_path);
        }


        $urls = [
            'logo' => $logo_url ?? $data->logo,
            'emblem' => $emblem_url ?? $data->emblem,
            'meta-image' => $meta_image_url ?? $data->meta_image
        ];

        // ***********************************
        // ** Parse S3 URLs to CDN addresss **
        // ***********************************

        foreach ($urls as $type => $url) {
            $urls[$type] = str_replace('https://avaxbucket.s3.amazonaws.com', 'https://cdn.flaremetrics.io', $url);
        }

        // ********************
        // ** Insert into DB **
        // ********************


        try {

            Ftso::where('id', $data->id)->update([
                'name' => $data->name,
                'code' => $data->code,
                'logo' => $urls['logo'],
                'emblem' => $urls['emblem'],
                'meta_image' => $urls['meta-image'],
                'description' => $data->description,
                'extended_description' => $data->extended_description,
                'website' => $data->website,
                'website_url' => $data->website_url,
                'info' => json_encode($data->info),
                'socials' => json_encode($data->socials),
                'admin_email' => $data->admin_email,
                'verified' => $data->verified,
                'feature_video' => $data->feature_video,
                'site_description' => $data->site_description,
            ]);
        } catch (\Exception $ex) {
            return [
                'error' => true,
                'message' => $ex
            ];
        }



        return [
            'error' => false,
            'message' => 'updated'
        ];
    }

    public function getProviderEmblem(Request $request, $address)
    {
        $size = $request->input('size') ?? 64;
        $pool = ProviderPool::where('address', $address)->first();

        if (!$pool) {
            $avatar = new InitialAvatar();
            $name = substr($address, 1) . ' ' . substr($address, -1);
            $image = $avatar->name($name)->rounded()->background('#8BC34A')->color('#fff')->size($size)->generate();
            return response($image->stream('png', 100), 200)
                ->header('Content-Type', 'image/png');
        }
        $provider = Ftso::where('id', $pool->ftso_id)->first();

        $image_path = str_replace(env('CDN_URL'), "", $provider->emblem);
        $image_path = str_replace("@64", "@{$size}", $image_path);

        $image = Storage::disk('s3')->get($image_path);
        return response($image, 200)
            ->header('Content-Type', 'image/png');
    }
}
