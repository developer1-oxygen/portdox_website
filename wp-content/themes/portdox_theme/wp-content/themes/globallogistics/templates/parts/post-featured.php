<?php
		if ($post_data['post_video']) {
						themerex_show_layout(themerex_get_video_frame($post_data['post_video'], $post_data['post_video_image'] ? $post_data['post_video_image'] : $post_data['post_thumb']));
		} else if ($post_data['post_audio']) {
						themerex_show_layout(themerex_get_audio_frame($post_data['post_audio'], $post_data['post_audio_image'] ? $post_data['post_audio_image'] : $post_data['post_thumb_url']));
		} else if ($post_data['post_thumb'] && ($post_data['post_format']!='gallery' || !$post_data['post_gallery'] || themerex_get_custom_option('gallery_instead_image')=='no')) {
			?>
			<div class="post_thumb">
			<?php
			if ($post_data['post_format']=='link' && $post_data['post_url']!='')
				echo '<a href="'.esc_url($post_data['post_url']).'"'.($post_data['post_url_target'] ? ' target="'.esc_attr($post_data['post_url_target']).'"' : '').'>'.($post_data['post_thumb']).'</a>';
			else if ($post_data['post_link']!='') {
				themerex_show_layout($post_data['post_thumb']);
				echo '<div class="hover_wrap">
						<div class="link_wrap">
							<a class="hover_link icon-link" href="' . esc_url($post_data['post_link']) . '"></a>
							<a class="hover_view icon-resize-full" href="'. esc_url($post_data['post_attachment']). '" title="'. esc_attr($post_data['post_title']). '"></a>
						</div>
					</div>';
			}
			else
							themerex_show_layout($post_data['post_thumb']);
			?>
			</div>
			<?php
		} else if ($post_data['post_gallery'] && function_exists('themerex_sc_slider')) {
			themerex_enqueue_slider();
						themerex_show_layout($post_data['post_gallery']);
		}
?>