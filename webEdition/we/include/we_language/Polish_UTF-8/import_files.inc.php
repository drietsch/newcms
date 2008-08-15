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
$GLOBALS["l_import_files"]["sameName_expl"] = "Określ zachowanie webEdition w przypadku wystąpienia takiej samej nazwy.";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Istniejący plik nadpisać";
$GLOBALS["l_import_files"]["sameName_rename"] = "Zapisać pod inna nazwą";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Nie importuj pliku";
$GLOBALS["l_import_files"]["sameName_headline"] = "Co zrobić<br>przy takiej samej nazwie?";
$GLOBALS["l_import_files"]["step1"] = "Importownie lokalnych plików - krok 1 z 2";
$GLOBALS["l_import_files"]["step2"] = "Importownie lokalnych plików - krok 2 z 2";
$GLOBALS["l_import_files"]["step3"] = "Import local files - Step 3 of 3"; // TRANSLATE
$GLOBALS["l_import_files"]["import_expl"] = "Poprzez kliknięcie przycisku obok pola wprowadzenia można wybrać plik z dysku. Po wyborze jednego ukarze się kolejne okno w którym można wybrać następne pliki. Należy uważać, aby maksymalna wielkość pliku nie przekroczyła %s!<br><br>Kliknij na \"Dalej\", aby rozpocząć importowanie.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "With the click on the button you can select more then one file from your harddrive. Alternatively the files can be selected per 'Drag and Drop' from the file manager.  Please note that the maximum filesize of  %s is not to be exceeded because of restrictions by PHP and MySQL!<br><br>Click on \"Next\", to start the import.";

$GLOBALS["l_import_files"]["error"] = "Wystąpił błąd podczas importu!\\n\\nNastępujący plik nie mógł zostać zaimportowany:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "Pomyślnie zakończono importowanie pliku!";
$GLOBALS["l_import_files"]["import_file"] = "Importuj plik %s";

$GLOBALS["l_import_files"]["no_perms"] = "Błąd: Brak uprawnień";
$GLOBALS["l_import_files"]["move_file_error"] = "Błąd: move_uploaded_file()";
$GLOBALS["l_import_files"]["read_file_error"] = "Błąd: fread()";
$GLOBALS["l_import_files"]["php_error"] = "Błąd: upload_max_filesize()";
$GLOBALS["l_import_files"]["same_name"] = "Błąd: Plik już istnieje";
$GLOBALS["l_import_files"]["save_error"] = "Błąd przy zapisie";
$GLOBALS["l_import_files"]["publish_error"] = "Błąd przy publikowaniu";

$GLOBALS["l_import_files"]["root_dir_1"] = "Jako folder źródłowy podałeś katalog Root serwera webowego. Jesteś pewien, że chcesz zaimportować całą zawartość katalogu Root?";
$GLOBALS["l_import_files"]["root_dir_2"] = "Jako folder docelowy podałeś katalog Root serwera webowego. Jesteś pewien, że chcesz zaimportować wszystko bezpośrednio do katalogu Root?";
$GLOBALS["l_import_files"]["root_dir_3"] = "Jako folder źródłowy i docelowy podałeś katalog Root. Jesteś pewien, że chcesz zaimportować całą zawartość katalogu Root z powrotem do katalogu Root?";

$GLOBALS["l_import_files"]["thumbnails"] = "Widok miniatury";
$GLOBALS["l_import_files"]["make_thumbs"] = "Utwórz<br>miniaturę";
$GLOBALS["l_import_files"]["image_options_open"] = "Wyświetl funkcje grafiki";
$GLOBALS["l_import_files"]["image_options_close"] = "Wyłącz funkcje grafiki";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "Aby działały funkcje grafiki musi zostać zainstalowana GD Library na serwerze!";

$GLOBALS["l_import_files"]["noFiles"] = "No files exist in the specified source directory which correspond with the given import settings!"; // TRANSLATE
$GLOBALS["l_import_files"]["emptyDir"] = "The source directory is empty!"; // TRANSLATE

?>