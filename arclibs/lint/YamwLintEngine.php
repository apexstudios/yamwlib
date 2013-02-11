<?php

/**
 * Basic lint engine which just applies several linters based on the file types
 *
 * @group linter
 */
final class YamwLintEngine extends ArcanistLintEngine {

  public function buildLinters() {
    $linters = array();

    $paths = $this->getPaths();

    foreach ($paths as $key => $path) {
      if (!$this->pathExists($path)) {
        unset($paths[$key]);
      }
      if (preg_match('@^externals/@', $path)) {
        // Third-party stuff lives in /externals/; don't run lint engines
        // against it.
        unset($paths[$key]);
      }
    }

    $text_paths = preg_grep('/\.(php|css|hpp|cpp|l|y)$/', $paths);
    $linters[] = id(new ArcanistGeneratedLinter())->setPaths($text_paths);
    $linters[] = id(new ArcanistNoLintLinter())->setPaths($text_paths);
    $linters[] = id(new ArcanistTextLinter())->setPaths($text_paths);

    $linters[] = id(new ArcanistFilenameLinter())->setPaths($paths);

    $linters[] = id(new ArcanistXHPASTLinterCustom())
      ->setPaths(preg_grep('/\.php$/', $paths));

    $linters[] = id(new ArcanistApacheLicenseLinter())
      ->setPaths(preg_grep('/\.(php|cpp|hpp|l|y)$/', $paths));

    $linters[] = id(new ArcanistRubyLinter())
      ->setPaths(preg_grep('/\.rb$/', $paths));

    $linters[] = id(new ArcanistJSHintLinter())
      ->setPaths(preg_grep('/\.js$/', $paths));

    return $linters;
  }

}
