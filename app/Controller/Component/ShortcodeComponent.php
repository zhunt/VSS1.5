<?php
class ShortcodeComponent extends Component {

    
var $shortcode_tags = array();

var $post, $content;

function process( $content, $post) {
    $this->content = $content;
    $this->post = $post;
    $this->add_shortcode( 'image' , 'shortcode_image');
    $this->add_shortcode( 'gallery' , 'shortcode_gallery');
    
    debug($this->helpers);
    debug($content);
    return ( $this->do_shortcode($content) );
    
   // return $post;
}

function add_shortcode($tag, $func) {
	$this->shortcode_tags;

	if ( is_callable( array('ShortcodeComponent', $func) ) )
		$this->shortcode_tags[$tag] = $func;
        
        debug($this->shortcode_tags);
}

/**
 * Removes hook for shortcode.
 *
 * @since 2.5
 * @uses $shortcode_tags
 *
 * @param string $tag shortcode tag to remove hook for.
 */
function remove_shortcode($tag) {
	$this->shortcode_tags;

	unset($shortcode_tags[$tag]);
}

/**
 * Clear all shortcodes.
 *
 * This function is simple, it clears all of the shortcode tags by replacing the
 * shortcodes global by a empty array. This is actually a very efficient method
 * for removing all shortcodes.
 *
 * @since 2.5
 * @uses $shortcode_tags
 */
function remove_all_shortcodes() {

	$this->shortcode_tags = array();
}

/**
 * Search content for shortcodes and filter shortcodes through their hooks.
 *
 * If there are no shortcode tags defined, then the content will be returned
 * without any filtering. This might cause issues when plugins are disabled but
 * the shortcode will still show up in the post or content.
 *
 * @since 2.5
 * @uses $shortcode_tags
 * @uses get_shortcode_regex() Gets the search pattern for searching shortcodes.
 *
 * @param string $content Content to search for shortcodes
 * @return string Content with shortcodes filtered out.
 */
function do_shortcode($content) {
	$this->shortcode_tags;

	if (empty($this->shortcode_tags) || !is_array($this->shortcode_tags))
		return $content;

	$pattern = $this->get_shortcode_regex();
	return preg_replace_callback( "/$pattern/s", array('ShortcodeComponent', 'do_shortcode_tag') , $content );
}


function get_shortcode_regex() {
	$this->shortcode_tags;
	$tagnames = array_keys($this->shortcode_tags);
	$tagregexp = join( '|', array_map('preg_quote', $tagnames) );

	// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
	return
		  '\\['                              // Opening bracket
		. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
		. "($tagregexp)"                     // 2: Shortcode name
		. '\\b'                              // Word boundary
		. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
		.     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
		.     '(?:'
		.         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
		.         '[^\\]\\/]*'               // Not a closing bracket or forward slash
		.     ')*?'
		. ')'
		. '(?:'
		.     '(\\/)'                        // 4: Self closing tag ...
		.     '\\]'                          // ... and closing bracket
		. '|'
		.     '\\]'                          // Closing bracket
		.     '(?:'
		.         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
		.             '[^\\[]*+'             // Not an opening bracket
		.             '(?:'
		.                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
		.                 '[^\\[]*+'         // Not an opening bracket
		.             ')*+'
		.         ')'
		.         '\\[\\/\\2\\]'             // Closing shortcode tag
		.     ')?'
		. ')'
		. '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
}


function do_shortcode_tag( $m ) {
	$this->shortcode_tags;

	// allow [[foo]] syntax for escaping a tag
	if ( $m[1] == '[' && $m[6] == ']' ) {
		return substr($m[0], 1, -1);
	}

	$tag = $m[2];
	$attr = $this->shortcode_parse_atts( $m[3] );

	if ( isset( $m[5] ) ) {
		// enclosing tag - extra parameter
		return $m[1] . call_user_func( array('ShortcodeComponent', $this->shortcode_tags[$tag]) , $attr, $m[5], $tag ) . $m[6];
	} else {
		// self-closing tag
		return $m[1] . call_user_func( array('ShortcodeComponent', $this->shortcode_tags[$tag]) , $attr, null,  $tag ) . $m[6];
	}
}


function shortcode_parse_atts($text) {
	$atts = array();
	$pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
	$text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
	if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
		foreach ($match as $m) {
			if (!empty($m[1]))
				$atts[strtolower($m[1])] = stripcslashes($m[2]);
			elseif (!empty($m[3]))
				$atts[strtolower($m[3])] = stripcslashes($m[4]);
			elseif (!empty($m[5]))
				$atts[strtolower($m[5])] = stripcslashes($m[6]);
			elseif (isset($m[7]) and strlen($m[7]))
				$atts[] = stripcslashes($m[7]);
			elseif (isset($m[8]))
				$atts[] = stripcslashes($m[8]);
		}
	} else {
		$atts = ltrim($text);
	}
	return $atts;
}

function shortcode_atts($pairs, $atts) {
	$atts = (array)$atts;
	$out = array();
	foreach($pairs as $name => $default) {
		if ( array_key_exists($name, $atts) )
			$out[$name] = $atts[$name];
		else
			$out[$name] = $default;
	}
	return $out;
}

function strip_shortcodes( $content ) {
	$this->shortcode_tags;

	if (empty($shortcode_tags) || !is_array($shortcode_tags))
		return $content;

	$pattern = $this->get_shortcode_regex();

	return preg_replace_callback( "/$pattern/s", 'strip_shortcode_tag', $content );
}

function strip_shortcode_tag( $m ) {
	// allow [[foo]] syntax for escaping a tag
	if ( $m[1] == '[' && $m[6] == ']' ) {
		return substr($m[0], 1, -1);
	}

	return $m[1] . $m[6];
}


/* ------------------------------------------------ */
function shortcode_image($attr, $content = null) {
    //debug($attr);
   // debug($content);
/*$attr: 	'num' => '2',
	'size' => 'half',
	'caption' => 'no caption' */    
    
    $folder = 'thumb/large';
    $imageField = 'image_1';
    $caption = '';
    $imageClass = 'span8';
    
    if (isset($attr['size'])) {
        switch ($attr['size']) {
            case 'full':
                $folder = 'thumb/large';
                break;
            case 'half';
                $folder = 'thumb/medium';
                $imageClass = 'span4';
                break;
            case 'small';
                $folder = 'thumb/small';
                break;            
            case 'orginal':
                $folder = '';
                break;
            default:
                $size = 'large';
        }
    }
    
    if (isset($attr['num'])) {
        $imageField = 'image_' . $attr['num'];
    }
    
   
    
   // debug($this->post);
    $imageName = $this->post['Post'][$imageField]; debug($imageName);
    $caption = $imageName;
    
    if (isset($attr['caption'])) {
        $caption = $attr['caption'];
    }
    
    $path = '/uploads/post/' . $imageField . '/' . $folder . '/' . $imageName; 
    //debug($path);
   
    $image = '<img src="' . $path . '" title="' . htmlentities( $this->Text->truncate($caption,30) ) .'" class="'  . $imageClass . '">';
    $html = $image;
    if (isset($attr['caption'])) {
        $html = '<div class="thumbnail">' . $image . '<p>' . $caption . '</p></div>';
    }
    
    return $html;
}

function shortcode_gallery($attr, $content = null) {
    debug($attr);
    debug($content);
    
    $html = '';// '<img src="/uploads/venue_detail/profile_image/thumb/medium/future_shop_young_dundas.jpg">';
    
    return $html;    
}


}
/* 
 * 	'num' => '2',
	'size' => 'half',
	'caption' => 'no caption'
 */
?>
