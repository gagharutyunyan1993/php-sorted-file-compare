# File Comparison Utility

## Overview
This project provides a PHP script that compares two text files containing ASCII strings sorted in lexicographical order. It generates two output files:
- The first contains strings found only in the first input file.
- The second contains strings found only in the second input file.

## Requirements
- **PHP 7.0 or later** – Ensure PHP is installed on your system.
- **Input Files** – Two text files (for example, `file1.txt` and `file2.txt`) with lexicographically sorted ASCII strings.

## Project Structure
- **compare.php** – The main script that performs the file comparison.
- **file1.txt** – The first input file.
- **file2.txt** – The second input file.
- **README.md** – This file, which provides an overview and instructions.

## Usage
1. **Check PHP Installation**  
   Run the following command to verify PHP is installed:
   ```bash
   php -v
   ```

2. **Place Files Together**  
   Ensure that `compare.php`, `file1.txt`, and `file2.txt` are in the same directory.

3. **Run the Script**  
   Execute the script from your command line:
   ```bash
   php compare.php
   ```
   The script will generate:
    - A file (e.g., `only_in_file1.txt`) containing strings unique to the first file.
    - A file (e.g., `only_in_file2.txt`) containing strings unique to the second file.

*Tip:* If you need to change the input or output file names, adjust the corresponding variables within `compare.php`.

## How It Works
Given that both input files are pre-sorted, the script employs a two-pointer technique to efficiently compare them:
- **Line-by-Line Reading:** Both files are read one line at a time.
- **String Comparison:**
    - If the strings on the current lines are identical, they are skipped.
    - If they differ, the lower (lexicographically smaller) string is written to its corresponding output file, and the pointer for that file advances.
- **Completion:** This process continues until all lines in both files have been processed.

This method ensures efficient processing, even with large files.

## Notes
- The script assumes that each file contains unique, sorted strings.
- It works with ASCII-encoded files. If your files are in a different encoding or contain extra formatting, consider preprocessing them accordingly.