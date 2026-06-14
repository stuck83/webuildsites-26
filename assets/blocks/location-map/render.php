<?php
/**
 * Location Map Frontend Render Engine
 *
 * @package accelerator
 */

$address = ! empty( $attributes['address'] ) ? esc_attr( $attributes['address'] ) : 'London, New United Kingdom';
$zoom    = ! empty( $attributes['zoom'] ) ? intval( $attributes['zoom'] ) : 13;

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'accelerator-map-container alignwide'
) );

$map_url = "https://maps.google.com/maps?q=" . urlencode( $address ) . "&t=&z=" . $zoom . "&ie=UTF8&iwloc=&output=embed";
?>

<div <?php echo $wrapper_attributes; ?>>
    <div class="map-inner-frame" style="position: relative; width: 100%; height: 450px; overflow: hidden; border-radius: 8px;">
        <iframe 
            width="100%" 
            height="100%" 
            src="<?php echo esc_url( $map_url ); ?>" 
            frameborder="0" 
            scrolling="no" 
            style="border:0; filter: grayscale(10%) contrast(110%);"
            loading="lazy">
        </iframe>
    </div>
</div>