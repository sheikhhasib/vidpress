<?php
/**
 * Load and initiate your blocks
 */

namespace VidPress;

use VidPress\Blocks\DynamicBlock;

class Blocks {

  public function __construct(){
    new DynamicBlock();
  }

}
