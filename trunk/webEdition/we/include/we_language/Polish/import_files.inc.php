<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Language file: import_files.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_import_files"]["destination_dir"] = "Destination directory"; // TRANSLATE
$GLOBALS["l_import_files"]["file"] = "Plik";
$GLOBALS["l_import_files"]["sameName_expl"] = "Okre¶l zachowanie webEdition w przypadku wyst±pienia takiej samej nazwy.";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Istniej±cy plik nadpisaæ";
$GLOBALS["l_import_files"]["sameName_rename"] = "Zapisaæ pod inna nazw±";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Nie importuj pliku";
$GLOBALS["l_import_files"]["sameName_headline"] = "Co zrobiæ<br>przy takiej samej nazwie?";
$GLOBALS["l_import_files"]["step1"] = "Importownie lokalnych plików - krok 1 z 2";
$GLOBALS["l_import_files"]["step2"] = "Importownie lokalnych plików - krok 2 z 2";
$GLOBALS["l_import_files"]["step3"] = "Import local files - Step 3 of 3"; // TRANSLATE
$GLOBALS["l_import_files"]["import_expl"] = "Poprzez klikniêcie przycisku obok pola wprowadzenia mo¿na wybraæ plik z dysku. Po wyborze jednego ukarze siê kolejne okno w którym mo¿na wybraæ nastêpne pliki. Nale¿y uwa¿aæ, aby maksymalna wielko¶æ pliku nie przekroczy³a %s!<br><br>Kliknij na \"Dalej\", aby rozpocz±æ importowanie.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "With the click on the button you can select more then one file from your harddrive. Alternatively the files can be selected per 'Drag and Drop' from the file manager.  Please note that the maximum filesize of  %s is not to be exceeded because of restrictions by PHP and MySQL!<br><br>Click on \"Next\", to start the import.";

$GLOBALS["l_import_files"]["error"] = "Wyst±pi³ b³±d podczas importu!\\n\\nNastêpuj±cy plik nie móg³ zostaæ zaimportowany:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "Pomy¶lnie zakoñczono importowanie pliku!";
$GLOBALS["l_import_files"]["import_file"] = "Importuj plik %s";

$GLOBALS["l_import_files"]["no_perms"] = "B³±d: Brak uprawnieñ";
$GLOBALS["l_import_files"]["move_file_error"] = "B³±d: move_uploaded_file()";
$GLOBALS["l_import_files"]["read_file_error"] = "B³±d: fread()";
$GLOBALS["l_import_files"]["php_error"] = "B³±d: upload_max_filesize()";
$GLOBALS["l_import_files"]["same_name"] = "B³±d: Plik ju¿ istnieje";
$GLOBALS["l_import_files"]["save_error"] = "B³±d przy zapisie";
$GLOBALS["l_import_files"]["publish_error"] = "B³±d przy publikowaniu";

$GLOBALS["l_import_files"]["root_dir_1"] = "Jako folder ¼ród³owy poda³e¶ katalog Root serwera webowego. Jeste¶ pewien, ¿e chcesz zaimportowaæ ca³± zawarto¶æ katalogu Root?";
$GLOBALS["l_import_files"]["root_dir_2"] = "Jako folder docelowy poda³e¶ katalog Root serwera webowego. Jeste¶ pewien, ¿e chcesz zaimportowaæ wszystko bezpo¶rednio do katalogu Root?";
$GLOBALS["l_import_files"]["root_dir_3"] = "Jako folder ¼ród³owy i docelowy poda³e¶ katalog Root. Jeste¶ pewien, ¿e chcesz zaimportowaæ ca³± zawarto¶æ katalogu Root z powrotem do katalogu Root?";

$GLOBALS["l_import_files"]["thumbnails"] = "Widok miniatury";
$GLOBALS["l_import_files"]["make_thumbs"] = "Utwórz<br>miniaturê";
$GLOBALS["l_import_files"]["image_options_open"] = "Wy¶wietl funkcje grafiki";
$GLOBALS["l_import_files"]["image_options_close"] = "Wy³±cz funkcje grafiki";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "Aby dzia³a³y funkcje grafiki musi zostaæ zainstalowana GD Library na serwerze!";

$GLOBALS["l_import_files"]["noFiles"] = "No files exist in the specified source directory which correspond with the given import settings!"; // TRANSLATE
$GLOBALS["l_import_files"]["emptyDir"] = "The source directory is empty!"; // TRANSLATE

?>