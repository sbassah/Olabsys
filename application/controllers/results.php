<?php
class Results extends CI_Controller {

        public function view($page = 'listing')
        {
		 if ( ! file_exists(APPPATH.'/views/results/'.$page.'.php'))
        {
                // Whoops, we don't have a page for that!
                show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('partial/headie', $data);
        $this->load->view('results/'.$page, $data);
        $this->load->view('partial/tail', $data);
        }
}
