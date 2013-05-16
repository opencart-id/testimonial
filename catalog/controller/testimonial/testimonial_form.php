<?php
class ControllerTestimonialTestimonialForm extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('testimonial/testimonial_form');

		$this->document->setTitle($this->language->get('heading_title'));

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/ym.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/testimonial.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/testimonial.css');
		}

		$this->load->model('testimonial/testimonial');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_testimonial_testimonial->addTestimonial($this->request->post);

			$this->redirect($this->url->link('testimonial/testimonial_form/success'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_location'] = $this->language->get('entry_location');
		$this->data['entry_url'] = $this->language->get('entry_url');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_rating'] = $this->language->get('entry_rating');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');
        
		$this->data['text_bad'] = $this->language->get('text_bad');
		$this->data['text_good'] = $this->language->get('text_good');
        
		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_submit'] = $this->language->get('button_submit');

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}

		if (isset($this->error['captcha'])) {
			$this->data['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['error_captcha'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home'),
			'separator'	=> false
		);

		$this->data['breadcrumbs'][] = array(
			'href'		=> $this->url->link('testimonial/testimonial_form'),
			'text'		=> $this->language->get('heading_title'),
			'separator'	=> $this->language->get('text_separator')
		);

		$this->data['action'] = $this->url->link('testimonial/testimonial_form');

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['url'])) {
			$this->data['url'] = $this->request->post['url'];
		} else {
			$this->data['url'] = '';
		}

		if (isset($this->request->post['location'])) {
			$this->data['location'] = $this->request->post['location'];
		} else {
			$this->data['location'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} else {
			$this->data['image'] = '';
		}
		
		if (isset($this->request->post['rating'])) {
			$this->data['rating'] = $this->request->post['rating'];
		} else {
			$this->data['rating'] = 0;
		}
		
		if (isset($this->request->post['description'])) {
			$this->data['description'] = $this->request->post['description'];
		} else {
			$this->data['description'] = '';
		}

		if (isset($this->request->post['captcha'])) {
			$this->data['captcha'] = $this->request->post['captcha'];
		} else {
			$this->data['captcha'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/testimonial/testimonial_form.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/testimonial/testimonial_form.tpl';
		} else {
			$this->template = 'default/template/testimonial/testimonial_form.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}

	public function success() {
		$this->language->load('testimonial/testimonial_form');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home'),
			'separator'	=> false
		);

		$this->data['breadcrumbs'][] = array(
			'href'		=> $this->url->link('testimonial/testimonial_form'),
			'text'		=> $this->language->get('heading_title'),
			'separator'	=> $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_message'] = sprintf($this->language->get('text_message'), $this->url->link('testimonial/testimonial'));

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render(TRUE));
	}

	protected function validate() {
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['description']) < 10) || (utf8_strlen($this->request->post['description']) > 3000)) {
			$this->error['description'] = $this->language->get('error_description');
		}

		if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
			$this->error['captcha'] = $this->language->get('error_captcha');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function captcha() {
		$this->load->library('captcha');

		$captcha = new Captcha();

		$this->session->data['captcha'] = $captcha->getCode();

		$captcha->showImage();
	}
    
	public function upload() {
		$this->language->load('testimonial/testimonial_form');

		$json = array();

		if (!empty($this->request->files['file']['name'])) {
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
				$json['error'] = $this->language->get('error_filename');
			}

			// Allowed file extension types
			$allowed = array();

			$filetypes = explode(',', 'png, jpe, jpeg, jpg, gif, bmp');

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Allowed file mime types
			$allowed = array();

			$filetypes = explode(',', 'image/png, image/jpeg, image/gif, image/bmp');

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!$json && is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
			$file = basename($filename);

			$json['file'] = $file;

			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_IMAGE . 'data/testimonial/' . $file);

			$json['success'] = $this->language->get('text_upload');
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>