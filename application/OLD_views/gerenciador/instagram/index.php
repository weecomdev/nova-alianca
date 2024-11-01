<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ul class="breadcrumb">
        <li class="active">Instagram</li>
    </ul>
</div>

<ul class="medias">
	<?php foreach ($instagram as $key => $media) { ?>
		<li data-img-id="<?php echo $media->image_id; ?>" data-id="<?php echo $media->instagram_id; ?>" class="<?php if($media->black_list === '1'){ echo 'added'; } ?>">
			<img src="<?php echo $media->img; ?>" class="image" width="308" alt="">
			<svg version="1.1" class="check" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"> <path id="x-mark-3-icon" d="M256,50C142.229,50,50,142.229,50,256s92.229,206,206,206s206-92.229,206-206S369.771,50,256,50z M334.124,378.545l-77.122-77.117l-77.123,77.127l-41.425-41.449l77.106-77.117l-77.115-77.11l41.448-41.424l77.103,77.092 l77.09-77.102l41.459,41.432l-77.104,77.108l77.113,77.102L334.124,378.545z"/> </svg>
		</li>
	<?php } ?>
</ul>

<?php $this->load->view('gerenciador/_footer')?>