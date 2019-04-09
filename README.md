# cmb2-field-cs-boxshadow
Box shadow field type for CMB2

## Example declaration

```php
$your_cmb_matabox->add_field(array(
	'id' => $prefix . 'cs_boxshadow',			
	'name' => __( 'Box shadow', 'cmb2' ),
	'desc' => __( 'Field description', 'cmb2' ),
	'type' => 'cs_boxshadow',
	'options' => array(
		'preview' => true, // Show/Hide the "preview" area
		'toggle' => true, // Display all box shadow fields inside collapsible area
	),
));
```
## Return values

<pre>
Array
(
    [horizontal_length] => 4
    [vertical_length] => 5
    [blur_radius] => 5
    [spread_radius] => 3
    [color] => #000000
    [opacity] => 0.12
    [box-shadow] => 4px 5px 5px 3px rgba(0,0,0,0.12)
)
</pre>

## Example 1

```php
$form_shadow = get_post_meta( get_the_ID(), 'your_field_id' );

echo "form{";
    echo "-webkit-box-shadow: " . $form_shadow['box-shadow'] . ";";
    echo "-moz-box-shadow: " . $form_shadow['box-shadow'] . ";";
    echo "box-shadow: " . $form_shadow['box-shadow'] . ";";
echo "}";
```

## Screenshot

<img src="https://github.com/codespacing/cmb2-field-cs-boxshadow/blob/master/cmb2-cs-boxshadow.png" />

## Changelog

<h3>1.0</h3>
<ul><li>Initial commit</li></ul>
