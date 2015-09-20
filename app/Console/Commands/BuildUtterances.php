<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RuntimeException;

class BuildUtterances extends Command
{
    const EXPAND_PATTERN = '/\[(number|optional|multiple):([A-Za-z0-9-\|]+)\]/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:utterances {app}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Builds a utterances file for the specified app';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $app = $this->argument('app');
        $inputFilename = base_path('schema/' . $app . '/utterances_input.txt');
        $outputFilename = base_path('schema/' . $app . '/utterances.txt');

        if (!file_exists($inputFilename)) {
            throw new InvalidArgumentException('Can\'t find input utterance file for app: ' . $app);
        }

        $this->buildUtterances($inputFilename, $outputFilename);
    }

    private function buildUtterances($inputFilename, $outputFilename) {
        $output = [];

        $lines = file($inputFilename);
        $lines = array_map('trim', $lines);

        foreach ($lines as $line) {
            if (preg_match(self::EXPAND_PATTERN, $line)) {
                $output = array_merge($output, $this->expandLine($line));
            } else {
                $output[] = $line;
            }
        }

        $output = array_unique($output);

        file_put_contents($outputFilename, implode(PHP_EOL, $output));
    }

    private function expandLine($line) {
        $lines = [$line];

        preg_match_all(self::EXPAND_PATTERN, $line, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            if ($match[1] === 'number') {
                if (strpos($match[2], '-') === FALSE) {
                    throw new RuntimeException('Invalid range (' . $match[2] . ') for number: ' . $line);
                }

                list($min, $max) = explode('-', $match[2]);
                $this->expandWithNumber($lines, $match[0], $min, $max);
            } elseif ($match[1] === 'optional') {
                $this->expandWithOptional($lines, $match[0], $match[2]);
            } elseif ($match[1] === 'multiple') {
                $this->expandWithMultiples($lines, $match[0], explode('|', $match[2]));
            }
        }

        return $lines;
    }

    private function expandWithNumber(&$lines, $replacementToken, $min, $max) {
        foreach ($lines as &$line) {
            if (strpos($line, $replacementToken) !== FALSE) {
                $originalLine = $line;

                for ($i = $min; $i <= $max; $i++) {
                    $generatedLine = str_replace($replacementToken, number_to_word($i), $originalLine);

                    if ($i === $min) {
                        $line = $generatedLine;
                    } else {
                        $lines[] = $generatedLine;
                    }
                }
            }
        }
    }

    private function expandWithOptional(&$lines, $replacementToken, $optionalWord) {
        foreach ($lines as &$line) {
            if (strpos($line, $replacementToken) !== FALSE) {
                $originalLine = $line;
                $line = trim(str_replace($replacementToken, '', $originalLine));
                $lines[] = str_replace($replacementToken, $optionalWord, $originalLine);
            }
        }
    }

    private function expandWithMultiples(&$lines, $replacementToken, $replacementWords) {
        foreach ($lines as &$line) {
            if (strpos($line, $replacementToken) !== FALSE) {
                $originalLine = $line;
                $line = '';

                foreach ($replacementWords as $replacementWord) {
                    $replacement = str_replace($replacementToken, $replacementWord, $originalLine);
                    
                    $lines[] = $replacement;
                }
            }
        }
    }
}
