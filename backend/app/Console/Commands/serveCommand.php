<?php

/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;



/**
 * Class serveCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ServeCommand extends Command
{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $signature = "serve";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Serve the API Server";


  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    try {
      echo ("Listening on http://localhost:8000 \n");
      echo ("Press Ctrl-C to quit. \n");
      exec("php -S localhost:8000 -t public");
    } catch (Exception $e) {
      $this->error("Terjadi kesalahan!");
    }
  }
}
