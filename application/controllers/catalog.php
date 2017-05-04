<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('media_model','',TRUE);
  }

  function index()
  {

      $pageTitle = "Full Catalog";
      $section = null;
      $items_per_page = 8;
      $search = null;

      if(isset($_GET['cat'])){

          if($_GET['cat'] == 'books'){
              $pageTitle = "Books";
              $section = "books";
          } elseif ($_GET['cat'] == 'movies') {
              $pageTitle = "Movies";
              $section = "movies";
          }elseif ($_GET['cat'] == 'music') {
              $pageTitle = "Music";
              $section = "music";
          }
      }
//search
      if(isset($_GET["s"])){
          $search = filter_input(INPUT_GET,"s", FILTER_SANITIZE_STRING);
      }

//pagination
      if(isset($_GET["pg"])){
          $current_page = filter_input(INPUT_GET,"pg", FILTER_SANITIZE_NUMBER_INT);
      }

      if(empty($current_page)){
          $current_page = 1;
      }
//pagination calculations
      $total_items = $this->media_model->get_catalog_count($section,$search);
      //$total_items = get_catalog_count($section,$search);
      $total_pages = 1;
      $offset = 0;

      if($total_items > 0){
          $total_pages = ceil($total_items / $items_per_page); //rounding the result

          //limit results in redirect
          $limit_results = "";
          if(!empty($search)){
              //validating $search value input by the user
              $limit_results = "s=".urlencode(htmlspecialchars($search))."&";
          }elseif(!empty($section)){
              $limit_results = "cat=".$section."&";
          }
          //redirect too-large page numbers to the last page
          if($current_page > $total_pages){
              header("location:catalog.php?".$limit_results."pg=".$total_pages);
          }
          //redirect too-small page numbers to the first page
          if($current_page < 1){
              header("location:catalog.php?".$limit_results."pg=1");
          }
          //determine the offset (numberm of items to skip) for the current page
          //for example: on page 3 with 8 items per page, the offset will be 16
          $offset = ($current_page - 1)  * $items_per_page;

          $catalog = $this->media_model->category_catalog_array($section,$items_per_page,$offset);
          //$catalog = category_catalog_array($section,$items_per_page,$offset);

          $pagination = "<div class = \"pagination\">";
          $pagination .= "Pages: ";
          for($i = 1; $i <= $total_pages; $i++){
              if($i == $current_page){
                  $pagination .= "<span> $i </span>";
              }else{
                  $pagination .= "<a href='catalog.php?";
                  if(!empty($search)){
                      //validating $search value input by the user
                      $pagination .= "s=".urlencode(htmlspecialchars($search))."&";
                  }elseif(!empty($section)){
                      $pagination .= "cat=".$section."&";
                  }
                  $pagination .= "pg=$i'> $i </a>";
              }
          }
          $pagination .= "</div>";

      }

      if(!empty($search)){
          $catalog = $this->media_model->search_catalog_array($section,$items_per_page,$offset);
          //$catalog = search_catalog_array($search,$items_per_page,$offset);
      }elseif(empty($section)){
          $catalog = $this->media_model->full_catalog_array($items_per_page,$offset);
          //$catalog = full_catalog_array($items_per_page,$offset);
      }else{
          $this->media_model->category_catalog_array($section,$items_per_page,$offset);
      }

      $data['section'] = null;
      $this->load->view('inc/header',$data);
      $this->load->view('login_view');
      $this->load->view('inc/footer');
  }


}
