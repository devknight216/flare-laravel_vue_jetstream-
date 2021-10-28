<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>

      <loc>https://flaremetrics.io/ftso</loc>

      <lastmod>2021-03-22</lastmod>

   </url>

   <url>

      <loc>https://flaremetrics.io/charts</loc>

      <lastmod>2021-03-22</lastmod>


   </url>
   <url>

      <loc>https://flaremetrics.io/yield-calculator</loc>

      <lastmod>2021-03-22</lastmod>

   </url>
   <url>

      <loc>https://flaremetrics.io/wallet-calculator</loc>

      <lastmod>2021-03-22</lastmod>

   </url>
   
   <url>

      <loc>https://docs.flaremetrics.io/</loc>

      <lastmod>2021-09-06</lastmod>

   </url>

   @foreach ($ftsos as $ftso)
        <url>
            <loc>{{url(env('APP_URL') . '/ftso/providers/' . $ftso->code)}}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($ftso->updated_at)) }}</lastmod>
        </url>
    @endforeach
   

</urlset> 