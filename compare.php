<?php

declare(strict_types=1);

/**
 * Compares two lexicographically sorted files and creates two output files:
 *
 * @param string $file1Path Path to the first input file.
 * @param string $file2Path Path to the second input file.
 * @param string $out1Path  Path to the output file for strings unique to the first file.
 * @param string $out2Path  Path to the output file for strings unique to the second file.
 *
 * @throws RuntimeException If any file cannot be opened.
 */
function compareSortedFiles(
    string $file1Path,
    string $file2Path,
    string $out1Path,
    string $out2Path
): void {
    $fh1 = fopen($file1Path, 'rb');
    if ($fh1 === false) {
        throw new RuntimeException(sprintf('Failed to open input file: %s', $file1Path));
    }

    $fh2 = fopen($file2Path, 'rb');
    if ($fh2 === false) {
        fclose($fh1);
        throw new RuntimeException(sprintf('Failed to open input file: %s', $file2Path));
    }

    $out1 = fopen($out1Path, 'wb');
    if ($out1 === false) {
        fclose($fh1);
        fclose($fh2);
        throw new RuntimeException(sprintf('Failed to open output file: %s', $out1Path));
    }

    $out2 = fopen($out2Path, 'wb');
    if ($out2 === false) {
        fclose($fh1);
        fclose($fh2);
        fclose($out1);
        throw new RuntimeException(sprintf('Failed to open output file: %s', $out2Path));
    }

    $readLine = static function ($h): ?string {
        $line = fgets($h);
        return $line === false ? null : rtrim($line, "\r\n");
    };

    try {
        $line1 = $readLine($fh1);
        $line2 = $readLine($fh2);

        while ($line1 !== null || $line2 !== null) {
            if ($line1 === null) {
                fwrite($out2, $line2 . PHP_EOL);
                $line2 = $readLine($fh2);
                continue;
            }

            if ($line2 === null) {
                fwrite($out1, $line1 . PHP_EOL);
                $line1 = $readLine($fh1);
                continue;
            }

            $cmp = strcmp($line1, $line2);

            if ($cmp === 0) {
                $val = $line1;
                while ($line1 !== null && $line1 === $val) {
                    $line1 = $readLine($fh1);
                }
                while ($line2 !== null && $line2 === $val) {
                    $line2 = $readLine($fh2);
                }
            } elseif ($cmp < 0) {
                fwrite($out1, $line1 . PHP_EOL);
                $line1 = $readLine($fh1);
            } else {
                fwrite($out2, $line2 . PHP_EOL);
                $line2 = $readLine($fh2);
            }
        }
    } finally {
        fclose($fh1);
        fclose($fh2);
        fclose($out1);
        fclose($out2);
    }
}

compareSortedFiles(
    'file1.txt',
    'file2.txt',
    'only_in_file1.txt',
    'only_in_file2.txt'
);