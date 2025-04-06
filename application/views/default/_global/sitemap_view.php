<?='<?xml version="1.0" encoding="UTF-8" ?>'?>

<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= base_url()?></loc> 
        <lastmod>2019-06-01</lastmod>
    </url>

    <?php foreach($urlset as $url) { ?>
    <url>
        <loc><?= base_url().$url ?></loc>
        <lastmod>2019-06-05</lastmod>
    </url>
    <?php } ?>

</urlset>