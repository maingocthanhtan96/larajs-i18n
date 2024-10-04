<?php namespace LaraJS\I18n\Commands;

use Illuminate\Console\Command;

use LaraJS\I18n\Generator;

class GenerateInclude extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larajs:i18n {--umd} {--multi} {--with-vendor} {--file-name=} {--lang-files=} {--format=json} {--multi-locales}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates a i18n compatible js array out of project translations";

    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $root = base_path() . config('i18n-generator.langPath');
        $config = config('i18n-generator');

        // options
        $umd = $this->option('umd');
        $multipleFiles = $this->option('multi');
        $withVendor = $this->option('with-vendor');
        $fileName = $this->option('file-name');
        $langFiles = $this->option('lang-files');
        $format = $this->option('format');
        $multipleLocales = $this->option('multi-locales');

        if ($umd) {
            // if the --umd option is set, set the $format to 'umd'
            $format = 'umd';
        }

        if (!$this->isValidFormat($format)) {
            throw new \RuntimeException('Invalid format passed: ' . $format);
        }

        if ($multipleFiles || $multipleLocales) {
            $files = (new Generator($config))
                ->generateMultiple($root, $format, $multipleLocales);

            if ($config['showOutputMessages']) {
                $this->info("Written to : " . $files);
            }

            return;
        }

        if ($langFiles) {
            $langFiles = explode(',', $langFiles);
        }

        $data = (new Generator($config))
            ->generateFromPath($root, $format, $withVendor, $langFiles);


        $jsFile = $this->getFileName($fileName);
        file_put_contents($jsFile, $data);

        if ($config['showOutputMessages']) {
            $this->info("Written to : " . $jsFile);
        }
    }

    /**
     * @param string $fileNameOption
     * @return string
     */
    private function getFileName($fileNameOption)
    {
        if (isset($fileNameOption)) {
            return base_path() . $fileNameOption;
        }

        return base_path() . config('i18n-generator.jsFile');
    }

    /**
     * @param string $format
     * @return boolean
     */
    private function isValidFormat($format)
    {
        $supportedFormats = ['es6', 'umd', 'json'];
        return in_array($format, $supportedFormats);
    }
}
