<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| PAGINATION CONFIG
| -------------------------------------------------------------------
| This file will contain some Pagination' settings.
|
|
| Defaults provided for twitter bootstrap 4.0
*/

/* This Application Must Be Used With BootStrap 4 *  */
$config['full_tag_open'] 	= '<div class="pagging text-center"><nav style="float: right;padding-right: 20px;"><ul class="pagination">';
$config['full_tag_close'] 	= '</ul></nav></div>';
$config['num_tag_open'] 	= '<li class="page-item"><span class="page-link">';
$config['num_tag_close'] 	= '</span></li>';
$config['cur_tag_open'] 	= '<li class="page-item active"><span class="page-link">';
$config['cur_tag_close'] 	= '<span class="sr-only">(current)</span></span></li>';
$config['next_tag_open'] 	= '<li class="page-item"><span class="page-link">';
$config['next_tagl_close'] 	= '<span aria-hidden="true">&raquo;</span></span></li>';
$config['prev_tag_open'] 	= '<li class="page-item"><span class="page-link">';
$config['prev_tagl_close'] 	= '</span></li>';
$config['first_tag_open'] 	= '<li class="page-item"><span class="page-link">';
$config['first_tagl_close'] = '</span></li>';
$config['last_tag_open'] 	= '<li class="page-item"><span class="page-link">';
$config['last_tagl_close'] 	= '</span></li>';

$per_page =25;
$config['uri_segment'] = 3;
$config['per_page'] =$per_page;
$config['use_page_numbers'] = TRUE;
$config['page_query_string'] = TRUE;
$config['reuse_query_string'] = true;