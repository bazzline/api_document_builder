# if you have used "tracking_snippet" in your configuration

## steps

* copy templates to your configuration path
```
cd <path to your configuration>
cp <path to this project>/source/Net/Bazzline/Component/ApiDocumentBuilder/Template/layout.html .
cp <path to this project>/source/Net/Bazzline/Component/ApiDocumentBuilder/Template/project_view.html .
```
* move the content of "tracking_snippet" into the "layout.html"
* adapt your configuration file
    * remove "tracking_snippet"
    * add following code snippet to your configuration file
```
    'template' => array(
        'layout'        => __DIR__ . '/layout.html',
        'project_view'  => __DIR__ . '/project_view.html'
    ),
```
