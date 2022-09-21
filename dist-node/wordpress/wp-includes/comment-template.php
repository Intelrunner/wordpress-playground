<?php
 function get_comment_author( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); $comment_ID = ! empty( $comment->comment_ID ) ? $comment->comment_ID : $comment_ID; if ( empty( $comment->comment_author ) ) { $user = ! empty( $comment->user_id ) ? get_userdata( $comment->user_id ) : false; if ( $user ) { $author = $user->display_name; } else { $author = __( 'Anonymous' ); } } else { $author = $comment->comment_author; } return apply_filters( 'get_comment_author', $author, $comment_ID, $comment ); } function comment_author( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); $author = get_comment_author( $comment ); echo apply_filters( 'comment_author', $author, $comment->comment_ID ); } function get_comment_author_email( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); return apply_filters( 'get_comment_author_email', $comment->comment_author_email, $comment->comment_ID, $comment ); } function comment_author_email( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); $author_email = get_comment_author_email( $comment ); echo apply_filters( 'author_email', $author_email, $comment->comment_ID ); } function comment_author_email_link( $linktext = '', $before = '', $after = '', $comment = null ) { $link = get_comment_author_email_link( $linktext, $before, $after, $comment ); if ( $link ) { echo $link; } } function get_comment_author_email_link( $linktext = '', $before = '', $after = '', $comment = null ) { $comment = get_comment( $comment ); $email = apply_filters( 'comment_email', $comment->comment_author_email, $comment ); if ( ( ! empty( $email ) ) && ( '@' !== $email ) ) { $display = ( '' !== $linktext ) ? $linktext : $email; $return = $before; $return .= sprintf( '<a href="%1$s">%2$s</a>', esc_url( 'mailto:' . $email ), esc_html( $display ) ); $return .= $after; return $return; } else { return ''; } } function get_comment_author_link( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); $url = get_comment_author_url( $comment ); $author = get_comment_author( $comment ); if ( empty( $url ) || 'http://' === $url ) { $return = $author; } else { $return = "<a href='$url' rel='external nofollow ugc' class='url'>$author</a>"; } return apply_filters( 'get_comment_author_link', $return, $author, $comment->comment_ID ); } function comment_author_link( $comment_ID = 0 ) { echo get_comment_author_link( $comment_ID ); } function get_comment_author_IP( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); return apply_filters( 'get_comment_author_IP', $comment->comment_author_IP, $comment->comment_ID, $comment ); } function comment_author_IP( $comment_ID = 0 ) { echo esc_html( get_comment_author_IP( $comment_ID ) ); } function get_comment_author_url( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); $url = ''; $id = 0; if ( ! empty( $comment ) ) { $author_url = ( 'http://' === $comment->comment_author_url ) ? '' : $comment->comment_author_url; $url = esc_url( $author_url, array( 'http', 'https' ) ); $id = $comment->comment_ID; } return apply_filters( 'get_comment_author_url', $url, $id, $comment ); } function comment_author_url( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); $author_url = get_comment_author_url( $comment ); echo apply_filters( 'comment_url', $author_url, $comment->comment_ID ); } function get_comment_author_url_link( $linktext = '', $before = '', $after = '', $comment = 0 ) { $url = get_comment_author_url( $comment ); $display = ( '' !== $linktext ) ? $linktext : $url; $display = str_replace( 'http://www.', '', $display ); $display = str_replace( 'http://', '', $display ); if ( '/' === substr( $display, -1 ) ) { $display = substr( $display, 0, -1 ); } $return = "$before<a href='$url' rel='external'>$display</a>$after"; return apply_filters( 'get_comment_author_url_link', $return ); } function comment_author_url_link( $linktext = '', $before = '', $after = '', $comment = 0 ) { echo get_comment_author_url_link( $linktext, $before, $after, $comment ); } function comment_class( $css_class = '', $comment = null, $post_id = null, $display = true ) { $css_class = 'class="' . implode( ' ', get_comment_class( $css_class, $comment, $post_id ) ) . '"'; if ( $display ) { echo $css_class; } else { return $css_class; } } function get_comment_class( $css_class = '', $comment_id = null, $post_id = null ) { global $comment_alt, $comment_depth, $comment_thread_alt; $classes = array(); $comment = get_comment( $comment_id ); if ( ! $comment ) { return $classes; } $classes[] = ( empty( $comment->comment_type ) ) ? 'comment' : $comment->comment_type; $user = $comment->user_id ? get_userdata( $comment->user_id ) : false; if ( $user ) { $classes[] = 'byuser'; $classes[] = 'comment-author-' . sanitize_html_class( $user->user_nicename, $comment->user_id ); $post = get_post( $post_id ); if ( $post ) { if ( $comment->user_id === $post->post_author ) { $classes[] = 'bypostauthor'; } } } if ( empty( $comment_alt ) ) { $comment_alt = 0; } if ( empty( $comment_depth ) ) { $comment_depth = 1; } if ( empty( $comment_thread_alt ) ) { $comment_thread_alt = 0; } if ( $comment_alt % 2 ) { $classes[] = 'odd'; $classes[] = 'alt'; } else { $classes[] = 'even'; } $comment_alt++; if ( 1 == $comment_depth ) { if ( $comment_thread_alt % 2 ) { $classes[] = 'thread-odd'; $classes[] = 'thread-alt'; } else { $classes[] = 'thread-even'; } $comment_thread_alt++; } $classes[] = "depth-$comment_depth"; if ( ! empty( $css_class ) ) { if ( ! is_array( $css_class ) ) { $css_class = preg_split( '#\s+#', $css_class ); } $classes = array_merge( $classes, $css_class ); } $classes = array_map( 'esc_attr', $classes ); return apply_filters( 'comment_class', $classes, $css_class, $comment->comment_ID, $comment, $post_id ); } function get_comment_date( $format = '', $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); $_format = ! empty( $format ) ? $format : get_option( 'date_format' ); $date = mysql2date( $_format, $comment->comment_date ); return apply_filters( 'get_comment_date', $date, $format, $comment ); } function comment_date( $format = '', $comment_ID = 0 ) { echo get_comment_date( $format, $comment_ID ); } function get_comment_excerpt( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); if ( ! post_password_required( $comment->comment_post_ID ) ) { $comment_text = strip_tags( str_replace( array( "\n", "\r" ), ' ', $comment->comment_content ) ); } else { $comment_text = __( 'Password protected' ); } $comment_excerpt_length = (int) _x( '20', 'comment_excerpt_length' ); $comment_excerpt_length = apply_filters( 'comment_excerpt_length', $comment_excerpt_length ); $excerpt = wp_trim_words( $comment_text, $comment_excerpt_length, '&hellip;' ); return apply_filters( 'get_comment_excerpt', $excerpt, $comment->comment_ID, $comment ); } function comment_excerpt( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); $comment_excerpt = get_comment_excerpt( $comment ); echo apply_filters( 'comment_excerpt', $comment_excerpt, $comment->comment_ID ); } function get_comment_ID() { $comment = get_comment(); $comment_ID = ! empty( $comment->comment_ID ) ? $comment->comment_ID : '0'; return apply_filters( 'get_comment_ID', $comment_ID, $comment ); } function comment_ID() { echo get_comment_ID(); } function get_comment_link( $comment = null, $args = array() ) { global $wp_rewrite, $in_comment_loop; $comment = get_comment( $comment ); if ( ! is_array( $args ) ) { $args = array( 'page' => $args ); } $defaults = array( 'type' => 'all', 'page' => '', 'per_page' => '', 'max_depth' => '', 'cpage' => null, ); $args = wp_parse_args( $args, $defaults ); $link = get_permalink( $comment->comment_post_ID ); if ( ! is_null( $args['cpage'] ) ) { $cpage = $args['cpage']; } else { if ( '' === $args['per_page'] && get_option( 'page_comments' ) ) { $args['per_page'] = get_option( 'comments_per_page' ); } if ( empty( $args['per_page'] ) ) { $args['per_page'] = 0; $args['page'] = 0; } $cpage = $args['page']; if ( '' == $cpage ) { if ( ! empty( $in_comment_loop ) ) { $cpage = get_query_var( 'cpage' ); } else { $cpage = get_page_of_comment( $comment->comment_ID, $args ); } } if ( 'oldest' === get_option( 'default_comments_page' ) && 1 === $cpage ) { $cpage = ''; } } if ( $cpage && get_option( 'page_comments' ) ) { if ( $wp_rewrite->using_permalinks() ) { if ( $cpage ) { $link = trailingslashit( $link ) . $wp_rewrite->comments_pagination_base . '-' . $cpage; } $link = user_trailingslashit( $link, 'comment' ); } elseif ( $cpage ) { $link = add_query_arg( 'cpage', $cpage, $link ); } } if ( $wp_rewrite->using_permalinks() ) { $link = user_trailingslashit( $link, 'comment' ); } $link = $link . '#comment-' . $comment->comment_ID; return apply_filters( 'get_comment_link', $link, $comment, $args, $cpage ); } function get_comments_link( $post_id = 0 ) { $hash = get_comments_number( $post_id ) ? '#comments' : '#respond'; $comments_link = get_permalink( $post_id ) . $hash; return apply_filters( 'get_comments_link', $comments_link, $post_id ); } function comments_link( $deprecated = '', $deprecated_2 = '' ) { if ( ! empty( $deprecated ) ) { _deprecated_argument( __FUNCTION__, '0.72' ); } if ( ! empty( $deprecated_2 ) ) { _deprecated_argument( __FUNCTION__, '1.3.0' ); } echo esc_url( get_comments_link() ); } function get_comments_number( $post_id = 0 ) { $post = get_post( $post_id ); if ( ! $post ) { $count = 0; } else { $count = $post->comment_count; $post_id = $post->ID; } return apply_filters( 'get_comments_number', $count, $post_id ); } function comments_number( $zero = false, $one = false, $more = false, $post_id = 0 ) { echo get_comments_number_text( $zero, $one, $more, $post_id ); } function get_comments_number_text( $zero = false, $one = false, $more = false, $post_id = 0 ) { $number = get_comments_number( $post_id ); if ( $number > 1 ) { if ( false === $more ) { $output = sprintf( _n( '%s Comment', '%s Comments', $number ), number_format_i18n( $number ) ); } else { if ( 'on' === _x( 'off', 'Comment number declension: on or off' ) ) { $text = preg_replace( '#<span class="screen-reader-text">.+?</span>#', '', $more ); $text = preg_replace( '/&.+?;/', '', $text ); $text = trim( strip_tags( $text ), '% ' ); if ( $text && ! preg_match( '/[0-9]+/', $text ) && false !== strpos( $more, '%' ) ) { $new_text = _n( '%s Comment', '%s Comments', $number ); $new_text = trim( sprintf( $new_text, '' ) ); $more = str_replace( $text, $new_text, $more ); if ( false === strpos( $more, '%' ) ) { $more = '% ' . $more; } } } $output = str_replace( '%', number_format_i18n( $number ), $more ); } } elseif ( 0 == $number ) { $output = ( false === $zero ) ? __( 'No Comments' ) : $zero; } else { $output = ( false === $one ) ? __( '1 Comment' ) : $one; } return apply_filters( 'comments_number', $output, $number ); } function get_comment_text( $comment_ID = 0, $args = array() ) { $comment = get_comment( $comment_ID ); $comment_content = $comment->comment_content; if ( is_comment_feed() && $comment->comment_parent ) { $parent = get_comment( $comment->comment_parent ); if ( $parent ) { $parent_link = esc_url( get_comment_link( $parent ) ); $name = get_comment_author( $parent ); $comment_content = sprintf( ent2ncr( __( 'In reply to %s.' ) ), '<a href="' . $parent_link . '">' . $name . '</a>' ) . "\n\n" . $comment_content; } } return apply_filters( 'get_comment_text', $comment_content, $comment, $args ); } function comment_text( $comment_ID = 0, $args = array() ) { $comment = get_comment( $comment_ID ); $comment_text = get_comment_text( $comment, $args ); echo apply_filters( 'comment_text', $comment_text, $comment, $args ); } function get_comment_time( $format = '', $gmt = false, $translate = true ) { $comment = get_comment(); $comment_date = $gmt ? $comment->comment_date_gmt : $comment->comment_date; $_format = ! empty( $format ) ? $format : get_option( 'time_format' ); $date = mysql2date( $_format, $comment_date, $translate ); return apply_filters( 'get_comment_time', $date, $format, $gmt, $translate, $comment ); } function comment_time( $format = '' ) { echo get_comment_time( $format ); } function get_comment_type( $comment_ID = 0 ) { $comment = get_comment( $comment_ID ); if ( '' === $comment->comment_type ) { $comment->comment_type = 'comment'; } return apply_filters( 'get_comment_type', $comment->comment_type, $comment->comment_ID, $comment ); } function comment_type( $commenttxt = false, $trackbacktxt = false, $pingbacktxt = false ) { if ( false === $commenttxt ) { $commenttxt = _x( 'Comment', 'noun' ); } if ( false === $trackbacktxt ) { $trackbacktxt = __( 'Trackback' ); } if ( false === $pingbacktxt ) { $pingbacktxt = __( 'Pingback' ); } $type = get_comment_type(); switch ( $type ) { case 'trackback': echo $trackbacktxt; break; case 'pingback': echo $pingbacktxt; break; default: echo $commenttxt; } } function get_trackback_url() { if ( get_option( 'permalink_structure' ) ) { $tb_url = trailingslashit( get_permalink() ) . user_trailingslashit( 'trackback', 'single_trackback' ); } else { $tb_url = get_option( 'siteurl' ) . '/wp-trackback.php?p=' . get_the_ID(); } return apply_filters( 'trackback_url', $tb_url ); } function trackback_url( $deprecated_echo = true ) { if ( true !== $deprecated_echo ) { _deprecated_argument( __FUNCTION__, '2.5.0', sprintf( __( 'Use %s instead if you do not want the value echoed.' ), '<code>get_trackback_url()</code>' ) ); } if ( $deprecated_echo ) { echo get_trackback_url(); } else { return get_trackback_url(); } } function trackback_rdf( $deprecated = '' ) { if ( ! empty( $deprecated ) ) { _deprecated_argument( __FUNCTION__, '2.5.0' ); } if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && false !== stripos( $_SERVER['HTTP_USER_AGENT'], 'W3C_Validator' ) ) { return; } echo '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
			xmlns:dc="http://purl.org/dc/elements/1.1/"
			xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
		<rdf:Description rdf:about="'; the_permalink(); echo '"' . "\n"; echo '    dc:identifier="'; the_permalink(); echo '"' . "\n"; echo '    dc:title="' . str_replace( '--', '&#x2d;&#x2d;', wptexturize( strip_tags( get_the_title() ) ) ) . '"' . "\n"; echo '    trackback:ping="' . get_trackback_url() . '"' . " />\n"; echo '</rdf:RDF>'; } function comments_open( $post_id = null ) { $_post = get_post( $post_id ); $post_id = $_post ? $_post->ID : 0; $open = ( $_post && ( 'open' === $_post->comment_status ) ); return apply_filters( 'comments_open', $open, $post_id ); } function pings_open( $post_id = null ) { $_post = get_post( $post_id ); $post_id = $_post ? $_post->ID : 0; $open = ( $_post && ( 'open' === $_post->ping_status ) ); return apply_filters( 'pings_open', $open, $post_id ); } function wp_comment_form_unfiltered_html_nonce() { $post = get_post(); $post_id = $post ? $post->ID : 0; if ( current_user_can( 'unfiltered_html' ) ) { wp_nonce_field( 'unfiltered-html-comment_' . $post_id, '_wp_unfiltered_html_comment_disabled', false ); echo "<script>(function(){if(window===window.parent){document.getElementById('_wp_unfiltered_html_comment_disabled').name='_wp_unfiltered_html_comment';}})();</script>\n"; } } function comments_template( $file = '/comments.php', $separate_comments = false ) { global $wp_query, $withcomments, $post, $wpdb, $id, $comment, $user_login, $user_identity, $overridden_cpage; if ( ! ( is_single() || is_page() || $withcomments ) || empty( $post ) ) { return; } if ( empty( $file ) ) { $file = '/comments.php'; } $req = get_option( 'require_name_email' ); $commenter = wp_get_current_commenter(); $comment_author = $commenter['comment_author']; $comment_author_email = $commenter['comment_author_email']; $comment_author_url = esc_url( $commenter['comment_author_url'] ); $comment_args = array( 'orderby' => 'comment_date_gmt', 'order' => 'ASC', 'status' => 'approve', 'post_id' => $post->ID, 'no_found_rows' => false, 'update_comment_meta_cache' => false, ); if ( get_option( 'thread_comments' ) ) { $comment_args['hierarchical'] = 'threaded'; } else { $comment_args['hierarchical'] = false; } if ( is_user_logged_in() ) { $comment_args['include_unapproved'] = array( get_current_user_id() ); } else { $unapproved_email = wp_get_unapproved_comment_author_email(); if ( $unapproved_email ) { $comment_args['include_unapproved'] = array( $unapproved_email ); } } $per_page = 0; if ( get_option( 'page_comments' ) ) { $per_page = (int) get_query_var( 'comments_per_page' ); if ( 0 === $per_page ) { $per_page = (int) get_option( 'comments_per_page' ); } $comment_args['number'] = $per_page; $page = (int) get_query_var( 'cpage' ); if ( $page ) { $comment_args['offset'] = ( $page - 1 ) * $per_page; } elseif ( 'oldest' === get_option( 'default_comments_page' ) ) { $comment_args['offset'] = 0; } else { $top_level_query = new WP_Comment_Query(); $top_level_args = array( 'count' => true, 'orderby' => false, 'post_id' => $post->ID, 'status' => 'approve', ); if ( $comment_args['hierarchical'] ) { $top_level_args['parent'] = 0; } if ( isset( $comment_args['include_unapproved'] ) ) { $top_level_args['include_unapproved'] = $comment_args['include_unapproved']; } $top_level_args = apply_filters( 'comments_template_top_level_query_args', $top_level_args ); $top_level_count = $top_level_query->query( $top_level_args ); $comment_args['offset'] = ( ceil( $top_level_count / $per_page ) - 1 ) * $per_page; } } $comment_args = apply_filters( 'comments_template_query_args', $comment_args ); $comment_query = new WP_Comment_Query( $comment_args ); $_comments = $comment_query->comments; if ( $comment_args['hierarchical'] ) { $comments_flat = array(); foreach ( $_comments as $_comment ) { $comments_flat[] = $_comment; $comment_children = $_comment->get_children( array( 'format' => 'flat', 'status' => $comment_args['status'], 'orderby' => $comment_args['orderby'], ) ); foreach ( $comment_children as $comment_child ) { $comments_flat[] = $comment_child; } } } else { $comments_flat = $_comments; } $wp_query->comments = apply_filters( 'comments_array', $comments_flat, $post->ID ); $comments = &$wp_query->comments; $wp_query->comment_count = count( $wp_query->comments ); $wp_query->max_num_comment_pages = $comment_query->max_num_pages; if ( $separate_comments ) { $wp_query->comments_by_type = separate_comments( $comments ); $comments_by_type = &$wp_query->comments_by_type; } else { $wp_query->comments_by_type = array(); } $overridden_cpage = false; if ( '' == get_query_var( 'cpage' ) && $wp_query->max_num_comment_pages > 1 ) { set_query_var( 'cpage', 'newest' === get_option( 'default_comments_page' ) ? get_comment_pages_count() : 1 ); $overridden_cpage = true; } if ( ! defined( 'COMMENTS_TEMPLATE' ) ) { define( 'COMMENTS_TEMPLATE', true ); } $theme_template = STYLESHEETPATH . $file; $include = apply_filters( 'comments_template', $theme_template ); if ( file_exists( $include ) ) { require $include; } elseif ( file_exists( TEMPLATEPATH . $file ) ) { require TEMPLATEPATH . $file; } else { require ABSPATH . WPINC . '/theme-compat/comments.php'; } } function comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) { $post_id = get_the_ID(); $post_title = get_the_title(); $number = get_comments_number( $post_id ); if ( false === $zero ) { $zero = sprintf( __( 'No Comments<span class="screen-reader-text"> on %s</span>' ), $post_title ); } if ( false === $one ) { $one = sprintf( __( '1 Comment<span class="screen-reader-text"> on %s</span>' ), $post_title ); } if ( false === $more ) { $more = _n( '%1$s Comment<span class="screen-reader-text"> on %2$s</span>', '%1$s Comments<span class="screen-reader-text"> on %2$s</span>', $number ); $more = sprintf( $more, number_format_i18n( $number ), $post_title ); } if ( false === $none ) { $none = sprintf( __( 'Comments Off<span class="screen-reader-text"> on %s</span>' ), $post_title ); } if ( 0 == $number && ! comments_open() && ! pings_open() ) { echo '<span' . ( ( ! empty( $css_class ) ) ? ' class="' . esc_attr( $css_class ) . '"' : '' ) . '>' . $none . '</span>'; return; } if ( post_password_required() ) { _e( 'Enter your password to view comments.' ); return; } echo '<a href="'; if ( 0 == $number ) { $respond_link = get_permalink() . '#respond'; echo apply_filters( 'respond_link', $respond_link, $post_id ); } else { comments_link(); } echo '"'; if ( ! empty( $css_class ) ) { echo ' class="' . $css_class . '" '; } $attributes = ''; echo apply_filters( 'comments_popup_link_attributes', $attributes ); echo '>'; comments_number( $zero, $one, $more ); echo '</a>'; } function get_comment_reply_link( $args = array(), $comment = null, $post = null ) { $defaults = array( 'add_below' => 'comment', 'respond_id' => 'respond', 'reply_text' => __( 'Reply' ), 'reply_to_text' => __( 'Reply to %s' ), 'login_text' => __( 'Log in to Reply' ), 'max_depth' => 0, 'depth' => 0, 'before' => '', 'after' => '', ); $args = wp_parse_args( $args, $defaults ); if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] ) { return; } $comment = get_comment( $comment ); if ( empty( $comment ) ) { return; } if ( empty( $post ) ) { $post = $comment->comment_post_ID; } $post = get_post( $post ); if ( ! comments_open( $post->ID ) ) { return false; } if ( get_option( 'page_comments' ) ) { $permalink = str_replace( '#comment-' . $comment->comment_ID, '', get_comment_link( $comment ) ); } else { $permalink = get_permalink( $post->ID ); } $args = apply_filters( 'comment_reply_link_args', $args, $comment, $post ); if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) { $link = sprintf( '<a rel="nofollow" class="comment-reply-login" href="%s">%s</a>', esc_url( wp_login_url( get_permalink() ) ), $args['login_text'] ); } else { $data_attributes = array( 'commentid' => $comment->comment_ID, 'postid' => $post->ID, 'belowelement' => $args['add_below'] . '-' . $comment->comment_ID, 'respondelement' => $args['respond_id'], 'replyto' => sprintf( $args['reply_to_text'], get_comment_author( $comment ) ), ); $data_attribute_string = ''; foreach ( $data_attributes as $name => $value ) { $data_attribute_string .= " data-${name}=\"" . esc_attr( $value ) . '"'; } $data_attribute_string = trim( $data_attribute_string ); $link = sprintf( "<a rel='nofollow' class='comment-reply-link' href='%s' %s aria-label='%s'>%s</a>", esc_url( add_query_arg( array( 'replytocom' => $comment->comment_ID, 'unapproved' => false, 'moderation-hash' => false, ), $permalink ) ) . '#' . $args['respond_id'], $data_attribute_string, esc_attr( sprintf( $args['reply_to_text'], get_comment_author( $comment ) ) ), $args['reply_text'] ); } return apply_filters( 'comment_reply_link', $args['before'] . $link . $args['after'], $args, $comment, $post ); } function comment_reply_link( $args = array(), $comment = null, $post = null ) { echo get_comment_reply_link( $args, $comment, $post ); } function get_post_reply_link( $args = array(), $post = null ) { $defaults = array( 'add_below' => 'post', 'respond_id' => 'respond', 'reply_text' => __( 'Leave a Comment' ), 'login_text' => __( 'Log in to leave a Comment' ), 'before' => '', 'after' => '', ); $args = wp_parse_args( $args, $defaults ); $post = get_post( $post ); if ( ! comments_open( $post->ID ) ) { return false; } if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) { $link = sprintf( '<a rel="nofollow" class="comment-reply-login" href="%s">%s</a>', wp_login_url( get_permalink() ), $args['login_text'] ); } else { $onclick = sprintf( 'return addComment.moveForm( "%1$s-%2$s", "0", "%3$s", "%2$s" )', $args['add_below'], $post->ID, $args['respond_id'] ); $link = sprintf( "<a rel='nofollow' class='comment-reply-link' href='%s' onclick='%s'>%s</a>", get_permalink( $post->ID ) . '#' . $args['respond_id'], $onclick, $args['reply_text'] ); } $formatted_link = $args['before'] . $link . $args['after']; return apply_filters( 'post_comments_link', $formatted_link, $post ); } function post_reply_link( $args = array(), $post = null ) { echo get_post_reply_link( $args, $post ); } function get_cancel_comment_reply_link( $text = '' ) { if ( empty( $text ) ) { $text = __( 'Click here to cancel reply.' ); } $style = isset( $_GET['replytocom'] ) ? '' : ' style="display:none;"'; $link = esc_html( remove_query_arg( array( 'replytocom', 'unapproved', 'moderation-hash' ) ) ) . '#respond'; $formatted_link = '<a rel="nofollow" id="cancel-comment-reply-link" href="' . $link . '"' . $style . '>' . $text . '</a>'; return apply_filters( 'cancel_comment_reply_link', $formatted_link, $link, $text ); } function cancel_comment_reply_link( $text = '' ) { echo get_cancel_comment_reply_link( $text ); } function get_comment_id_fields( $post_id = 0 ) { if ( empty( $post_id ) ) { $post_id = get_the_ID(); } $reply_to_id = isset( $_GET['replytocom'] ) ? (int) $_GET['replytocom'] : 0; $result = "<input type='hidden' name='comment_post_ID' value='$post_id' id='comment_post_ID' />\n"; $result .= "<input type='hidden' name='comment_parent' id='comment_parent' value='$reply_to_id' />\n"; return apply_filters( 'comment_id_fields', $result, $post_id, $reply_to_id ); } function comment_id_fields( $post_id = 0 ) { echo get_comment_id_fields( $post_id ); } function comment_form_title( $no_reply_text = false, $reply_text = false, $link_to_parent = true ) { global $comment; if ( false === $no_reply_text ) { $no_reply_text = __( 'Leave a Reply' ); } if ( false === $reply_text ) { $reply_text = __( 'Leave a Reply to %s' ); } $reply_to_id = isset( $_GET['replytocom'] ) ? (int) $_GET['replytocom'] : 0; if ( 0 == $reply_to_id ) { echo $no_reply_text; } else { $comment = get_comment( $reply_to_id ); if ( $link_to_parent ) { $author = '<a href="#comment-' . get_comment_ID() . '">' . get_comment_author( $comment ) . '</a>'; } else { $author = get_comment_author( $comment ); } printf( $reply_text, $author ); } } function wp_list_comments( $args = array(), $comments = null ) { global $wp_query, $comment_alt, $comment_depth, $comment_thread_alt, $overridden_cpage, $in_comment_loop; $in_comment_loop = true; $comment_alt = 0; $comment_thread_alt = 0; $comment_depth = 1; $defaults = array( 'walker' => null, 'max_depth' => '', 'style' => 'ul', 'callback' => null, 'end-callback' => null, 'type' => 'all', 'page' => '', 'per_page' => '', 'avatar_size' => 32, 'reverse_top_level' => null, 'reverse_children' => '', 'format' => current_theme_supports( 'html5', 'comment-list' ) ? 'html5' : 'xhtml', 'short_ping' => false, 'echo' => true, ); $parsed_args = wp_parse_args( $args, $defaults ); $parsed_args = apply_filters( 'wp_list_comments_args', $parsed_args ); if ( null !== $comments ) { $comments = (array) $comments; if ( empty( $comments ) ) { return; } if ( 'all' !== $parsed_args['type'] ) { $comments_by_type = separate_comments( $comments ); if ( empty( $comments_by_type[ $parsed_args['type'] ] ) ) { return; } $_comments = $comments_by_type[ $parsed_args['type'] ]; } else { $_comments = $comments; } } else { if ( $parsed_args['page'] || $parsed_args['per_page'] ) { $current_cpage = get_query_var( 'cpage' ); if ( ! $current_cpage ) { $current_cpage = 'newest' === get_option( 'default_comments_page' ) ? 1 : $wp_query->max_num_comment_pages; } $current_per_page = get_query_var( 'comments_per_page' ); if ( $parsed_args['page'] != $current_cpage || $parsed_args['per_page'] != $current_per_page ) { $comment_args = array( 'post_id' => get_the_ID(), 'orderby' => 'comment_date_gmt', 'order' => 'ASC', 'status' => 'approve', ); if ( is_user_logged_in() ) { $comment_args['include_unapproved'] = array( get_current_user_id() ); } else { $unapproved_email = wp_get_unapproved_comment_author_email(); if ( $unapproved_email ) { $comment_args['include_unapproved'] = array( $unapproved_email ); } } $comments = get_comments( $comment_args ); if ( 'all' !== $parsed_args['type'] ) { $comments_by_type = separate_comments( $comments ); if ( empty( $comments_by_type[ $parsed_args['type'] ] ) ) { return; } $_comments = $comments_by_type[ $parsed_args['type'] ]; } else { $_comments = $comments; } } } else { if ( empty( $wp_query->comments ) ) { return; } if ( 'all' !== $parsed_args['type'] ) { if ( empty( $wp_query->comments_by_type ) ) { $wp_query->comments_by_type = separate_comments( $wp_query->comments ); } if ( empty( $wp_query->comments_by_type[ $parsed_args['type'] ] ) ) { return; } $_comments = $wp_query->comments_by_type[ $parsed_args['type'] ]; } else { $_comments = $wp_query->comments; } if ( $wp_query->max_num_comment_pages ) { $default_comments_page = get_option( 'default_comments_page' ); $cpage = get_query_var( 'cpage' ); if ( 'newest' === $default_comments_page ) { $parsed_args['cpage'] = $cpage; } elseif ( 1 == $cpage ) { $parsed_args['cpage'] = ''; } else { $parsed_args['cpage'] = $cpage; } $parsed_args['page'] = 0; $parsed_args['per_page'] = 0; } } } if ( '' === $parsed_args['per_page'] && get_option( 'page_comments' ) ) { $parsed_args['per_page'] = get_query_var( 'comments_per_page' ); } if ( empty( $parsed_args['per_page'] ) ) { $parsed_args['per_page'] = 0; $parsed_args['page'] = 0; } if ( '' === $parsed_args['max_depth'] ) { if ( get_option( 'thread_comments' ) ) { $parsed_args['max_depth'] = get_option( 'thread_comments_depth' ); } else { $parsed_args['max_depth'] = -1; } } if ( '' === $parsed_args['page'] ) { if ( empty( $overridden_cpage ) ) { $parsed_args['page'] = get_query_var( 'cpage' ); } else { $threaded = ( -1 != $parsed_args['max_depth'] ); $parsed_args['page'] = ( 'newest' === get_option( 'default_comments_page' ) ) ? get_comment_pages_count( $_comments, $parsed_args['per_page'], $threaded ) : 1; set_query_var( 'cpage', $parsed_args['page'] ); } } $parsed_args['page'] = (int) $parsed_args['page']; if ( 0 == $parsed_args['page'] && 0 != $parsed_args['per_page'] ) { $parsed_args['page'] = 1; } if ( null === $parsed_args['reverse_top_level'] ) { $parsed_args['reverse_top_level'] = ( 'desc' === get_option( 'comment_order' ) ); } wp_queue_comments_for_comment_meta_lazyload( $_comments ); if ( empty( $parsed_args['walker'] ) ) { $walker = new Walker_Comment; } else { $walker = $parsed_args['walker']; } $output = $walker->paged_walk( $_comments, $parsed_args['max_depth'], $parsed_args['page'], $parsed_args['per_page'], $parsed_args ); $in_comment_loop = false; if ( $parsed_args['echo'] ) { echo $output; } else { return $output; } } function comment_form( $args = array(), $post_id = null ) { if ( null === $post_id ) { $post_id = get_the_ID(); } if ( ! comments_open( $post_id ) ) { do_action( 'comment_form_comments_closed' ); return; } $commenter = wp_get_current_commenter(); $user = wp_get_current_user(); $user_identity = $user->exists() ? $user->display_name : ''; $args = wp_parse_args( $args ); if ( ! isset( $args['format'] ) ) { $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml'; } $req = get_option( 'require_name_email' ); $html5 = 'html5' === $args['format']; $required_attribute = ( $html5 ? ' required' : ' required="required"' ); $checked_attribute = ( $html5 ? ' checked' : ' checked="checked"' ); $required_indicator = ' <span class="required" aria-hidden="true">*</span>'; $fields = array( 'author' => sprintf( '<p class="comment-form-author">%s %s</p>', sprintf( '<label for="author">%s%s</label>', __( 'Name' ), ( $req ? $required_indicator : '' ) ), sprintf( '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245"%s />', esc_attr( $commenter['comment_author'] ), ( $req ? $required_attribute : '' ) ) ), 'email' => sprintf( '<p class="comment-form-email">%s %s</p>', sprintf( '<label for="email">%s%s</label>', __( 'Email' ), ( $req ? $required_indicator : '' ) ), sprintf( '<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />', ( $html5 ? 'type="email"' : 'type="text"' ), esc_attr( $commenter['comment_author_email'] ), ( $req ? $required_attribute : '' ) ) ), 'url' => sprintf( '<p class="comment-form-url">%s %s</p>', sprintf( '<label for="url">%s</label>', __( 'Website' ) ), sprintf( '<input id="url" name="url" %s value="%s" size="30" maxlength="200" />', ( $html5 ? 'type="url"' : 'type="text"' ), esc_attr( $commenter['comment_author_url'] ) ) ), ); if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) { $consent = empty( $commenter['comment_author_email'] ) ? '' : $checked_attribute; $fields['cookies'] = sprintf( '<p class="comment-form-cookies-consent">%s %s</p>', sprintf( '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />', $consent ), sprintf( '<label for="wp-comment-cookies-consent">%s</label>', __( 'Save my name, email, and website in this browser for the next time I comment.' ) ) ); if ( isset( $args['fields'] ) && ! isset( $args['fields']['cookies'] ) ) { $args['fields']['cookies'] = $fields['cookies']; } } $required_text = sprintf( ' <span class="required-field-message" aria-hidden="true">' . __( 'Required fields are marked %s' ) . '</span>', trim( $required_indicator ) ); $fields = apply_filters( 'comment_form_default_fields', $fields ); $defaults = array( 'fields' => $fields, 'comment_field' => sprintf( '<p class="comment-form-comment">%s %s</p>', sprintf( '<label for="comment">%s%s</label>', _x( 'Comment', 'noun' ), $required_indicator ), '<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525"' . $required_attribute . '></textarea>' ), 'must_log_in' => sprintf( '<p class="must-log-in">%s</p>', sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) ) ) ), 'logged_in_as' => sprintf( '<p class="logged-in-as">%s%s</p>', sprintf( __( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>' ), get_edit_user_link(), esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.' ), $user_identity ) ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) ) ), $required_text ), 'comment_notes_before' => sprintf( '<p class="comment-notes">%s%s</p>', sprintf( '<span id="email-notes">%s</span>', __( 'Your email address will not be published.' ) ), $required_text ), 'comment_notes_after' => '', 'action' => site_url( '/wp-comments-post.php' ), 'id_form' => 'commentform', 'id_submit' => 'submit', 'class_container' => 'comment-respond', 'class_form' => 'comment-form', 'class_submit' => 'submit', 'name_submit' => 'submit', 'title_reply' => __( 'Leave a Reply' ), 'title_reply_to' => __( 'Leave a Reply to %s' ), 'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">', 'title_reply_after' => '</h3>', 'cancel_reply_before' => ' <small>', 'cancel_reply_after' => '</small>', 'cancel_reply_link' => __( 'Cancel reply' ), 'label_submit' => __( 'Post Comment' ), 'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />', 'submit_field' => '<p class="form-submit">%1$s %2$s</p>', 'format' => 'xhtml', ); $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) ); $args = array_merge( $defaults, $args ); if ( isset( $args['fields']['email'] ) && false === strpos( $args['comment_notes_before'], 'id="email-notes"' ) ) { $args['fields']['email'] = str_replace( ' aria-describedby="email-notes"', '', $args['fields']['email'] ); } do_action( 'comment_form_before' ); ?>
	<div id="respond" class="<?php echo esc_attr( $args['class_container'] ); ?>">
		<?php
 echo $args['title_reply_before']; comment_form_title( $args['title_reply'], $args['title_reply_to'] ); if ( get_option( 'thread_comments' ) ) { echo $args['cancel_reply_before']; cancel_comment_reply_link( $args['cancel_reply_link'] ); echo $args['cancel_reply_after']; } echo $args['title_reply_after']; if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : echo $args['must_log_in']; do_action( 'comment_form_must_log_in_after' ); else : printf( '<form action="%s" method="post" id="%s" class="%s"%s>', esc_url( $args['action'] ), esc_attr( $args['id_form'] ), esc_attr( $args['class_form'] ), ( $html5 ? ' novalidate' : '' ) ); do_action( 'comment_form_top' ); if ( is_user_logged_in() ) : echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); else : echo $args['comment_notes_before']; endif; $comment_fields = array( 'comment' => $args['comment_field'] ) + (array) $args['fields']; $comment_fields = apply_filters( 'comment_form_fields', $comment_fields ); $comment_field_keys = array_diff( array_keys( $comment_fields ), array( 'comment' ) ); $first_field = reset( $comment_field_keys ); $last_field = end( $comment_field_keys ); foreach ( $comment_fields as $name => $field ) { if ( 'comment' === $name ) { echo apply_filters( 'comment_form_field_comment', $field ); echo $args['comment_notes_after']; } elseif ( ! is_user_logged_in() ) { if ( $first_field === $name ) { do_action( 'comment_form_before_fields' ); } echo apply_filters( "comment_form_field_{$name}", $field ) . "\n"; if ( $last_field === $name ) { do_action( 'comment_form_after_fields' ); } } } $submit_button = sprintf( $args['submit_button'], esc_attr( $args['name_submit'] ), esc_attr( $args['id_submit'] ), esc_attr( $args['class_submit'] ), esc_attr( $args['label_submit'] ) ); $submit_button = apply_filters( 'comment_form_submit_button', $submit_button, $args ); $submit_field = sprintf( $args['submit_field'], $submit_button, get_comment_id_fields( $post_id ) ); echo apply_filters( 'comment_form_submit_field', $submit_field, $args ); do_action( 'comment_form', $post_id ); echo '</form>'; endif; ?>
	</div><!-- #respond -->
	<?php
 do_action( 'comment_form_after' ); } 