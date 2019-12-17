<div>
	<h3>Editor's Comment Post Listing</h3>
	<table class='table oec-post-list'>
		<thead>
			<tr>
				<th>Post Title</th>
				<th>Editor Comment Count</th>
				<th>Comment Link</th>
			</tr>
		</thead>
		<tbody> <?php					
			while($query->have_posts()) :
				$query->the_post();
				$id = get_the_ID();
				$link = $url . $id; ?>
			<tr>
				<td><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></td>
				<td><?php _e($db->editorsCommentCount( $id )[0][0]);?></td>
				<td><a href="<?php _e($link);?>">Edit</a></td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>

	<div class="pagination"> <?php 
        echo paginate_links( array(
            'total'        => $query->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'prev_next'    => true,
            'prev_text'    => sprintf( '<i></i> %1$s', __( 'Previous', 'text-domain' ) ),
            'next_text'    => sprintf( '%1$s <i></i>', __( 'Next', 'text-domain' ) ),
        ) ); ?>
	</div>
</div>	