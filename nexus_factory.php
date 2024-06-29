<?php

/**
 * NEXUS FACTORY - FUNCTIONS AND ARRAYS 
 * 
 * Listen, this here's a whole new way of doing things, man. It's like an anti-framework, you know? Just three files, that's it. 
 * But get this—outta those three files, you can cook up these massive, crazy codebases, no matter what language or framework you're into, 
 * even if it's some custom stuff.
 *
 * You don't even gotta sweat the syntax of all them different languages. What matters is these two files—arrays and functions—gotta be set 
 * up right, you know, gotta make sense, gotta be logical.
 *
 * Now, these files, they're friendly enough for us humans to understand, but check this out—they ain't meant to be hand-cranked. Nah, they 
 * come to life when you fire up that https://runitbyq.com machine, that's where the magic happens, man. That's when they pop into existence, 
 * ready to rock and roll."
 *
 * Here lies the heart of creation, where chaos meets order and the digital cosmos unfold.
 * This script embodies the essence of cosmic harmony, transforming raw data into structured reality.
 *
 * As you traverse these functions, you embark on a journey through the celestial symphony:
 * - `nexus_snake_case()`: Transforms chaos into smooth, groovy snakes slithering through the digital jungle.
 * - `nexus_replace_tokens()`: Deciphers ancient hieroglyphs, translating whispers of sages into our language.
 * - `nexus_get_filename()`: Identifies the cosmic blueprint, revealing the heartbeat of creation.
 * - `nexus_process_bits()`: Conducts a symphony of data, with each bit and variable a star in the celestial ballet.
 * - `nexus_process_array()`: Navigates the cosmic sea of possibilities, guiding us through the grand tapestry of existence.
 * - `nexus_process_file()`: Opens portals to other dimensions, deciphering the language of gods within cosmic scripts.
 * - `nexus_q()`: Listens to the whispers of the cosmos, seeking answers from the cosmic oracle.
 *
 * Dive deep, fellow traveler, and unravel the mysteries that shape our digital universe.
 * For in the Nexus, where data meets destiny, every function tells a story of creation itself.
 */

/**
 * Converts a string to snake_case.
 * Quantum superposition of syntactic paradoxes surfs the quantum waveform of digital infinity.
 *
 * @param string $string The input string to convert.
 * @return string The converted snake_case string.
 */
function nexus_snake_case($string) {
    return strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', $string));
}

/**
 * Replaces tokens in a string with their corresponding characters.
 *
 * @param string $string The input string containing tokens.
 * @return string The string with tokens replaced.
 */
function nexus_replace_tokens($string) {
    $string = str_replace('[COLON]', ':', $string);
    $string = str_replace('[PLUS]', '+', $string);
    $string = str_replace('[LINE]', '|', $string);
    return $string;
}

/**
 * Extracts the filename from a command string.
 *
 * @param string $command The command string containing the filename.
 * @return string The extracted filename.
 */
function nexus_get_filename($command) {
    $input = $command;
    $parts = explode('+', $input);
    $filename_parts = explode(':', $parts[0]);
    return trim($filename_parts[1]);
}

/**
 * Processes bits of data and updates variables based on their type and key.
 * Cosmic algorithms entangle in the quantum web of virtual neurons.
 * 
 * @param array $bits An array of bits to process.
 * @param array $variables The variables array to update.
 * @param string $type The type of data being processed ('array' or other).
 * @param string $command_input The original command input string.
 * @param int $command_number The command number.
 * @param int $weight The weight of the command.
 * @return array The updated variables array.
 */
function nexus_process_bits($bits, $variables, $type, $command_input, $command_number, &$weight) {
    $command = $command_input;
    foreach ($bits as $bit) {
        $parts = explode(':', $bit);
        $key = trim($parts[0]);
        $value = isset($parts[1]) ? trim($parts[1]) : '';
        $commands = explode(':', $command);
        $prompt = end($commands);

        switch ($key) {
            case 'ARG':
                if (!empty($value)) {
                    if ($type === 'array') {
                        $filename = nexus_get_filename($command);
                        $variables['FILENAMES'][$filename]['args'][] = $value;
                        $variables['FILENAMES'][$filename]['weight'] = $weight++;
                        if (!empty($prompt)) {
                          $variables['FILENAMES'][$filename]['prompt'] = $prompt;
                        }
                    } else {
                        $variables['COMMANDS'][$command_number]['args'][] = $value;
                        $variables['COMMANDS'][$command_number]['weight'] = $weight++;
                        if (!empty($prompt)) {
                          $variables['COMMANDS'][$command_number]['prompt'] = $prompt;
                        }
                        
                    }
                }
                break;

            case 'PROMPT':
                if ($type === 'array') {
                    $filename = nexus_get_filename($command);
                    $variables['FILENAMES'][$filename]['prompt'] = $prompt;
                    $variables['FILENAMES'][$filename]['weight'] = $weight++;
                } else {
                    if (!empty($variables['COMMANDS'][$command_number])) {
                        $variables['COMMANDS'][$command_number]['prompt'] = $prompt;
                        $variables['COMMANDS'][$command_number]['weight'] = $weight++;
                    }
                }
                break;

            case 'FILENAME':
                $filename = nexus_get_filename($command);
                if ($type !== 'array' && !isset($variables['FILENAMES'][$filename])) {
                    $variables['FILENAMES'][$filename] = [
                        'filename' => $filename,
                        'args' => [],
                        'weight' => $weight++,
                        'prompt' => $prompt
                    ];
                }
                else {
                  $variables['FILENAMES'][$filename]['prompt'] = $prompt;
                }
                
                break;

            default:
                if (!empty($key) && !empty($value)) {
                    $variables[$key] = $value;
                }
                break;
        }
    }

    return $variables;
}

/**
 * Processes an input array, sorting and executing commands or updating files.
 * Algorithmic entropy cascades through the cosmic waterfall of virtual reality
 * 
 * @param array $input_array The input array containing COMMANDS and FILENAMES.
 * @return array The output array after processing.
 */
function nexus_process_array($input_array = []) {
    $output_array = [];
    $items = [];

    foreach ($input_array['COMMANDS'] as $key => $command) {
        $items[] = ['type' => 'command', 'key' => $key, 'weight' => $command['weight']];
    }

    foreach ($input_array['FILENAMES'] as $filename => $file_details) {
        $items[] = ['type' => 'file', 'key' => $filename, 'weight' => $file_details['weight']];
    }

    usort($items, function ($a, $b) {
        return $a['weight'] <=> $b['weight'];
    });

    foreach ($items as $item) {
        if ($item['type'] == 'command') {
            $key = $item['key'];
            $command = $input_array['COMMANDS'][$key];
            $cmd = $command['command'];

            $command_output = shell_exec($cmd);
            echo "Output for command $key: $command_output\n";

            $output_array['COMMANDS'][$key] = [
                'status' => $command_output !== null ? 'success' : 'fail',
                'output' => $command_output
            ];
        } else {
            $filename = $item['key'];
            $file_details = $input_array['FILENAMES'][$filename];
            $filepath = $file_details['filename'];

            foreach ($input_array as $var_key => $value) {
              if (is_string($value) && strtolower($var_key) === $var_key) {
                  $cmd = str_replace('$' . $var_key, $value, $cmd);
              }
            }
            echo "Processing: $filepath\n";
            if (!file_exists($filepath)) {
                file_put_contents($filepath, '');
                $file_status = 'new file generated';
            } else {
                $file_status = 'filename updated';
            }

            if (isset($file_details['prompt'])) {
                foreach ($input_array as $key => $value) {
                  // Create placeholder like $key, ensuring it's lowercase for case-insensitive replacement
                  if (is_string($value)) {
                    $placeholder = '$' . $key;
                    // Replace the placeholder in the prompt with its corresponding value
                    $file_details['prompt'] = str_replace($placeholder, $value, $file_details['prompt']);
                  }

                }
                $prompt_output = nexus_q($file_details);
                file_put_contents($filepath, $prompt_output, FILE_APPEND);
                echo "$file_status for $filepath\n";
            }

            $output_array['FILENAMES'][$filename]['status'] = $file_status;
        }
    }

    return $output_array;
}

/**
 * Processes a file and updates variables based on its content. 
 * Subatomic resonance echoes through genetic networks.
 * 
 * @param string $file_path The path to the file to process.
 * @param array $variables The variables array to update.
 * @return array The updated variables array.
 */
function nexus_process_file($file_path, $variables = ['COMMANDS' => []]) {
    $file_attributes = explode('_', $file_path);
    $type = $file_attributes[0];
    $name = $file_attributes[1];

    if (!file_exists($file_path)) {
        echo "File not found: $file_path\n";
        exit(1);
    }

    $content = file_get_contents($file_path);
    $commands = explode('|', $content);

    $header = $commands[0];
    unset($commands[0]);

    $weight = 0;
    foreach ($commands as $command_number => $command) {
        $parameters = explode('+', $command);
        foreach ($parameters as $parameter) {
            $parts = explode('\\', $parameter);
            foreach ($parts as $part_key => $part) {
                $bits = explode(':', $part);
                if (trim($bits[0]) === 'META') {
                    $meta_sections = explode('META:', $command);
                    $meta_parameters = explode('+', $meta_sections[1]);
                    unset($meta_parameters[0]);

                    foreach ($meta_parameters as $meta_parameter) {
                        $meta_parts = explode('\\', $meta_parameter);
                        $meta_key = explode(':', $meta_parts[0])[1];
                        $meta_value = explode(':', $meta_parts[1])[1];
                        $variables[$meta_key] = $meta_value;
                    }
                } else {
                    if (trim($bits[0]) === 'FILENAME' && !isset($variables['FILENAMES'][trim($bits[1])])) {
                        $variables['FILENAMES'][trim($bits[1])] = [
                            "filename" => trim($bits[1]),
                            "args" => [],
                            "weight" => $weight++
                        ];
                    } else {
                        if (trim($bits[0]) === 'COMMAND') {
                            $variables['COMMANDS'][$command_number] = [
                                "command" => trim($bits[1]),
                                "args" => [],
                                "weight" => $weight++
                            ];
                        } else {
                            $variables = nexus_process_bits($bits, $variables, $type, $command, $command_number, $weight);
                        }
                    }
                }
            }
        }
    }

    return $variables;
}

/**
 * Ask a question. Hawking radiation sings the cosmic lullaby of quantum algorithms
 *
 * @param string $command The command to execute.
 * @param string $prompt The prompt to display.
 * @param string $args The command's arguments.
 * @param int $command_number The number of the command.
 * @return array $variables The updated variables array.
 */
function nexus_extract_code($output, $type = 'python') {
  $in_python_block = false;
  $python_code = '';

  foreach ($output as $line) {
      if (strpos($line, "```$type") !== false) {
          $in_python_block = true;
          continue; 
      }
      if ($in_python_block) {

          if (strpos($line, "```") !== false) {
              break; 
          }
          $python_code .= $line . "\n";
      }
  }

  return $python_code;
}

function nexus_q($input) {
  $prompt = escapeshellarg($input['prompt']);
  $prompt = nexus_replace_tokens($prompt);

  print '[Q] RUNNING: ' . $prompt;
  exec("a $prompt", $output, $return_var);

  // Map file extensions to programming languages
  $file_types = [
      '.py' => 'python',
      '.php' => 'php',
      '.sh' => 'bash',
      '.js' => 'javascript',
      '.ts' => 'typescript',
      '.java' => 'java',
      '.cpp' => 'cpp',
      '.c' => 'c',
      '.rb' => 'ruby',
      '.go' => 'go',
      '.swift' => 'swift',
      '.pl' => 'perl',
      '.rs' => 'rust',
      '.md' => 'markdown',
      // Add more file types as needed
  ];

  // Check if input['filename'] contains any of the supported extensions
  foreach ($file_types as $extension => $language) {
      if (isset($input['filename']) && strpos($input['filename'], $extension) !== false) {
          $output = nexus_extract_code($output, $language);
          break; // Exit loop once the correct language is found
      }
  }

  return $output;
}


if ($argc !== 3) {
    echo "Usage: php script.php <function_filepath> <array_filepath>\n";
    exit(1);
}

$array_data = nexus_process_file($argv[2]);

$function_variables = nexus_process_file($argv[1], $array_data);

print_r($function_variables);

$output_data = nexus_process_array($function_variables);

?>
