<?php namespace Mvc;

  interface Listable{
    public function get_color_preview();
    public function get_icon_preview();
  }

  interface Printable{
    public function printPreview();
  }

 ?>
