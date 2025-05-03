<?php

namespace VidPress;

class Installer {
   /**
    * Run the installer
    *
    * @return void
    */
   public function run() {
       $this->add_version();
   }

   /**
    * Add time and version on DB
    */
   public function add_version() {
       $installed = get_option( 'VidPress_installed' );

       if ( ! $installed ) {
           update_option( 'VidPress_installed', time() );
       }

       update_option( 'VidPress_installed', VIDPRESS_VERSION );
   }

}
