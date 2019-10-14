<?php

namespace AdminLTE\Utility;

class Compression {

    // https://stackoverflow.com/questions/11265914/how-can-i-extract-or-uncompress-gzip-file-using-php
    public static function gunzip($source, $destination)
    {
        // Raising this value may increase performance
        $buffer_size = 4096; // read 4kb at a time
        $out_file_name = str_replace('.gz', '', $destination);

        // Open our files (in binary mode)
        $file = gzopen($source, 'rb');
        $out_file = fopen($out_file_name, 'wb');

        // Keep repeating until the end of the input file
        while (!gzeof($file)) {
            // Read buffer-size bytes
            // Both fwrite and gzread and binary-safe
            fwrite($out_file, gzread($file, $buffer_size));
        }

        // Files are done, close files
        fclose($out_file);
        gzclose($file);
    }
}
