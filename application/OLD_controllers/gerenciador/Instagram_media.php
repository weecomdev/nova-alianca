<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instagram_Media extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('InstagramImage');
	}
	
	public function index($status=0)
	{
        
        $this->save($this->getDataInstagram(null,'novaalianca'));
        $this->save($this->getDataInstagram(null,'sucoalianca'));
        $this->save($this->getDataInstagram(null,'aliancadaterra'));
        $this->save($this->getDataInstagram(null,'aliancaorganico'));
        $this->save($this->getDataInstagram(null,'santacolina'));
        $this->save($this->getDataInstagram(null,'cerrodacruz'));
        $this->save($this->getDataInstagram(null,'necalianca'));
	   // $this->save($this->getDataInstagram(null,'revivaainfancia'));

		$this->data['instagram'] = $this->InstagramImage->getAll();
		$this->load->view('gerenciador/instagram/index', $this->data);

		$myString = 'atualizado em: ' . date("d/m/Y H:i:s");
        $ALL = $myString."\r\n";
        file_put_contents('activity.log', $ALL, FILE_APPEND | LOCK_EX);
	}

	public function getMedias($min_img_id, $instagram_id){
		if(!empty($min_img_id)){
			$this->save($this->getDataInstagram($min_img_id));
			echo json_encode($this->InstagramImage->getAll($instagram_id));
		}
	}

	public function save($data)
	{
        if(!empty($data)){
    		foreach($data as $k=>$item){
    			if(!$this->InstagramImage->get($item->id)){

    				$data['image_id'] = $item->id;
    				$data['img'] = $item->images->low_resolution->url;
    				$data['likes'] = $item->likes->count;
    				$data['time'] = $item->caption->created_time;
    				$data['comments'] = $item->comments->count;
    				$data['profile_pic'] = $item->caption->from->profile_picture;
    				$data['user_name'] = $item->caption->from->username;
    				$data['link'] = $item->link;

    				$this->InstagramImage->save($data);
    			}else{
    				$data['image_id'] = $item->id;
    				$data['likes'] = $item->likes->count;
    				$data['comments'] = $item->comments->count;

    				$this->InstagramImage->update($data);
    			}

    		}
		    return $data;
        }
	}


	public function onBlackList($image_id, $value){
		if(!empty($image_id)){
			var_dump($image_id, $value);
			$this->InstagramImage->saveBlackList($image_id, $value);
		}
	}

	public function delete($image_id)
	{
		if(!empty($image_id))
		{
			if($this->InstagramImage->saveBlackList($image_id))
			{
				$this->setMessage($this->lang->line('message_item_removed'));
				redirect('gerenciador/instagram_media');
			}
			else
			{
				$this->setMessage('Erro ao atualizar Status.', true);
				$this->index();
			}
		}
		else
		{
			$this->setMessage($this->lang->line('message_item_removed_error'), true);
			$this->index();
		}
	}

	private function getDataInstagram($min_img_id=null,$tag=null)
	{
		require_once 'Instagram.class.php';

		$client_secret = '198b27cc764a4b43bd104c0971d2c98b';
		$client_id = 'bc8aa61c6a3d4bbfb416016eb9407250';

		$instagram = new Instagram($client_id);
		//var_dump($instagram);die();
	    // $tag = 'isf2014';
	    //$tag = 'novaalianca';

	    $media = $instagram->getTagMedia($tag);
	    $get_media = array();

	    $size_sd = '308';
		$size_hd = '800';
		$size_profile = "50";

		if (!empty($media->data))
			return $media->data;
		return NULL;
	}
}

?>