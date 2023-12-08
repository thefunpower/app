<?php
require(__DIR__."/vendor/autoload.php");
error_reporting(0);
$openapi = \OpenApi\Generator::scan([__DIR__.'/app']); 

$body = $openapi->toYaml();
file_put_contents(__DIR__.'/openapi.yaml',$body);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description"  content="接口" />
    <title>接口</title> 
    <script src="/node_modules/swagger-ui/dist/swagger-ui-bundle.js" ></script>
    <script src="/node_modules/swagger-ui/dist/swagger-ui-standalone-preset.js" ></script> 
    <link rel="stylesheet" href="/node_modules/swagger-ui/dist/swagger-ui.css" />
  </head>
  <body style="padding:0;margin:0;">
  <div id="swagger-ui"></div>
  <script>
    

    window.onload = () => {
      window.ui = SwaggerUIBundle({
        url: '/openapi.yaml',
        dom_id: '#swagger-ui',
        lang: 'zh_CN',
        langs: [
          {
            code: 'en_US',
            name: 'English'
          },
          {
            code: 'zh_CN',
            name: '中文'
          }
        ], 
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIStandalonePreset
        ],
        // BaseLayout StandaloneLayout
        layout: "BaseLayout",
      });
    }; 

  </script>
  </body>
</html>
