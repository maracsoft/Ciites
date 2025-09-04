<?php

namespace Tests;

use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
  use CreatesApplication;

  /**
   * Prepare for Dusk test execution.
   *
   * @beforeClass
   * @return void
   */
  public static function prepare()
  {
    if (! static::runningInSail()) {
      static::startChromeDriver();
    }
  }

  /**
   * Create the RemoteWebDriver instance.
   *
   * @return \Facebook\WebDriver\Remote\RemoteWebDriver
   */
  protected function driver()
  {

    $arguments = ['--window-size=1920,1080'];
    $options = (new ChromeOptions)->addArguments($arguments);

    $options->setBinary($this->getBinaryPath());

    $selenium_server_url = $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515';

    return RemoteWebDriver::create(
      $selenium_server_url,
      DesiredCapabilities::chrome()->setCapability(
        ChromeOptions::CAPABILITY,
        $options
      )
    );
  }

  private function getBinaryPath(): string
  {
    $proy_folder = env('PROYECT_FOLDER');
    $binary_chrome_path = "$proy_folder\\tests\\testing-chrome-win64\\chrome.exe";
    if (!file_exists($binary_chrome_path)) {
      throw new Exception("No se encontro el archivo binario para ejecución de chrome $binary_chrome_path");
    }

    return $binary_chrome_path;
  }

  /**
   * Determine whether the Dusk command has disabled headless mode.
   *
   * @return bool
   */
  protected function hasHeadlessDisabled()
  {
    return isset($_SERVER['DUSK_HEADLESS_DISABLED']) ||
      isset($_ENV['DUSK_HEADLESS_DISABLED']);
  }
}
