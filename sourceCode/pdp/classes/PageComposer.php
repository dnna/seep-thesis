<?php

/**
 * Φορτώνει τα κατάλληλα module, δημιουργεί το menu ανάλογα με το που υπάρχει
 * πρόσβαση και συνθέτει την τελική σελίδα που βλέπει ο χρήστης.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class PageComposer {

    /**
     * Επιστρέφει ένα associative array με τα MenuItems που υπάρχουν στην
     * αριστερή, δεξία, κεντρική και βοηθητική (βρίσκεται πάνω από την κεντρική,
     * εκεί δηλαδή που βρίσκεται by default το κουμπί Βοήθεια) θέση. Για όλα τα
     * αντικείμενα που επιστρέφονται έχει εξασφαλιστεί ότι ο χρήστης έχει
     * πρόσβαση και ότι αυτά έχουν οριστεί να είναι ορατά.
     * @return mixed Πίνακας με τα αντικείμενα του menu.
     */
    protected function generateMenu() {
        $menuHelp = Array();
        $menuLeft = Array();
        $menuCenter = Array();
        $menuRight = Array();
        $handle = opendir('modules');
        if ($handle) {
            while (($curModule = readdir($handle)) !== false) {
                if (is_dir('modules/' . $curModule) && $curModule != "." && $curModule != "..") {
                    unset($mDescr); // Unset previous to prevent bugs and improve security
                    if (file_exists('modules/' . $curModule . '/ModuleDescr.php')) {
                        include('modules/' . $curModule . '/ModuleDescr.php'); // Load module info
                        // Menu Generation
                        if (User::getUser()->hasAccess($curModule)) {
                            // Add menu items
                            if (isset($mDescr['MenuSide'])) {
                                if ($mDescr['MenuSide'] === 'help') {
                                    array_push($menuHelp, new MenuItem($mDescr['MenuTitle'], $mDescr['MenuWeight'], $mDescr['MenuURL']));
                                } else if ($mDescr['MenuSide'] === 'left') {
                                    array_push($menuLeft, new MenuItem($mDescr['MenuTitle'], $mDescr['MenuWeight'], $mDescr['MenuURL']));
                                } else if ($mDescr['MenuSide'] === 'center') {
                                    array_push($menuCenter, new MenuItem($mDescr['MenuTitle'], $mDescr['MenuWeight'], $mDescr['MenuURL']));
                                } else if ($mDescr['MenuSide'] === 'right') {
                                    array_push($menuRight, new MenuItem($mDescr['MenuTitle'], $mDescr['MenuWeight'], $mDescr['MenuURL']));
                                }
                            }
                        }
                    }
                }
            }
            closedir($handle);
        }

        usort($menuHelp, array("MenuItem", "cmp"));
        usort($menuLeft, array("MenuItem", "cmp"));
        usort($menuCenter, array("MenuItem", "cmp"));
        usort($menuRight, array("MenuItem", "cmp"));
        $menus['help'] = $menuHelp;
        $menus['left'] = $menuLeft;
        $menus['center'] = $menuCenter;
        $menus['right'] = $menuRight;
        return $menus;
    }

    /**
     * Φορτώνει και επιστρέφει το module που του δίνεται σαν παράμετρος. Αν
     * το module δεν μπορέσει να φορτωθεί τότε πετάει το κατάλληλο Exception και
     * επιστρέφει false.
     * @param String $curModule Όνομα του module που θα φορτωθεί.
     * @return IModule Το module που φορτώθηκε, ή false αν υπήρξε πρόβλημα.
     */
    protected function loadModule($curModule) {
        // Module loading
        if ($curModule == null || $curModule === '') {
            return false;
        }
        if (!file_exists('modules/' . $curModule . '/ModuleDescr.php')) {
            throw new ModuleLoadException('Το συγκεκριμένο module δεν υπάρχει.', 404);
        }
        @include('modules/' . $curModule . '/ModuleDescr.php'); // Load module info
        if (!User::getUser()->hasAccess($curModule)) {
            throw new ModuleLoadException('Ο χρήστης δεν έχει πρόσβαση στο συγκεκριμένο module.', 401);
        }
        include('modules/' . $curModule . '/' . $curModule . '.php'); // Include class
        return new $curModule;
    }

    /**
     * Δοκιμάζει να αυθεντικοποιήσει τον χρήστη. Αν τα στοιχεία είναι έγκυρα
     * τότε τα προσθέτει στο session και ανακατευθύνει στην προηγούμενη σελίδα
     * (referer). Αν όχι τότε πετάει LoginException.
     */
    protected function login() {
        global $_POST;
        if(!isset($_POST['username']) || !isset($_POST['password'])) {
            throw new LoginException('Λάθος username ή password.', 20001); // Αν δεν υπήρχε αυτό θα έβγαζε warnings στην παρακάτω γραμμή
        }
        $authResult = DataHandler::get()->authenticateUser($_POST['username'], $_POST['password']);
        if ($authResult == false) {
            throw new LoginException('Λάθος username ή password.', 20001);
        }
        $user = new User($authResult['userID'], $authResult['userRoles'], $authResult['userName'], $authResult['userLastName'], $authResult['userFirstName']);
        $_SESSION['user'] = $user;
        if(strpos(parse_url(PageComposer::getReferer(), PHP_URL_QUERY), 'module=') === false) {
            // Αν ο χρήστης κάνει login ενώ βρίσκεται στην αρχική σελίδα θα μεταβεί σε κάποια αντίστοιχη αρχική σελίδα
            if($user->hasRole('student')) {
                header('Location: ?module=ViewPersonalSchedule#hideSidebar');
            } else if($user->hasRole('teacher')) {
                header('Location: ?module=ManageLabParameters');
            } else if($user->hasRole('admin')) {
                header('Location: ?module=ViewStatistics');
            } else {
                throw new LoginException('Ο χρήστης δεν είναι ανώνυμος, αλλά δεν έχει και κανένα ρόλο.', 20002);
            }
        } else {
            // Αν ο χρήστης βρισκόταν σε άλλη σελίδα τότε θα παραμείνει εκεί που ήταν
            header('Location: ' . PageComposer::getReferer());
        }
        die(); // Δεν κάνουμε τίποτα άλλο αφού θα γίνει redirect
    }

    /**
     * Αποσυνδέει τον χρήστη από το σύστημα. Καταστρέφει το session, σβήνει
     * όλα τα σχετικά cookies και στη συνέχεια ανακατευθύνει στην προηγούμενη
     * σελίδα, αν υπάρχει ανώνυμη πρόσβαση σε αυτή. Αν όχι τότε ανακατευθύνει
     * στην αρχική σελίδα.
     */
    protected function logout() {
        global $_SERVER;
        $_SESSION = Array(); // Unset all of the session variables.*/
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, // Delete session cookie
                    $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        };
        session_destroy(); // Finally, destroy the session.
        if (PageComposer::anonymousAllowedToUrl($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . PageComposer::getReferer());
        } else {
            header('Location: .');
        }
        die(); // Nothing else needs to run since we are redirecting
    }

    /**
     * Επιστρέφει την προηγούμενη σελίδα (referer) ή το κενό String '' αν δεν
     * υπάρχει (π.χ. επειδή ο χρήστης το έχει απενεργοποιήσει στον browser του).
     * @return String Επιστρέφει το referer ή το κενό String '' αν δεν υπάρχει.
     */
    public static function getReferer() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        } else {
            return '';
        }
    }

    /**
     * Ελέγχει αν επιτρέπεται η ανώνυμη πρόσβαση στο module που δηλώνει το
     * συγκεκριμένο URL. Ένα παράδειγμα χρήστης είναι ο έλεγχος του referer
     * για το αν υπάρχει πρόσβαση στο συγκεκριμένο module.
     * @param String $url Το URL για το οποίο θα γίνει ο έλεγχος.
     * @return bool Επιστρέφει true αν επιτρέπεται ή false αν απαγορεύεται.
     */
    public static function anonymousAllowedToURL($url) {
        $queryString = parse_url($url, PHP_URL_QUERY);
        if (($queryString = stristr($queryString, 'module=')) != false) {
            $module = stristr($queryString, '&', true);
            $module = substr($module, strlen('module='));
            @include('modules/' . $module . '/ModuleDescr.php');
            if ($mDescr['Roles'] == null) {
                return false;
            }
            foreach ($mDescr['Roles'] as $curRole) {
                if ($curRole === 'anonymous') {
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * Συνθέτει την τελική σελίδα, δηλαδή αυτή που θα δει ο χρήστης.
     */
    public function compose() {
        global $_GET;
        session_start();
        if (isset($_GET['login']) && User::getUser()->getID() === '-1') { // Login
            $this->login();
        } else if (isset($_GET['logout']) && User::getUser()->getID() !== '-1') { // Logout
            $this->logout();
        }
        TemplateEngine::get()->handle()->assignByRef('auth', User::getUser());

        // Menu generation
        $menus = $this->generateMenu();
        TemplateEngine::get()->handle()->assignByRef('menuHelp', $menus['help']);
        TemplateEngine::get()->handle()->assignByRef('menuLeft', $menus['left']);
        TemplateEngine::get()->handle()->assignByRef('menuCenter', $menus['center']);
        TemplateEngine::get()->handle()->assignByRef('menuRight', $menus['right']);

        //Module loading
        if (isset($_GET['module'])) {
            $module = $this->loadModule($_GET['module']);
        } else {
            $module = false;
        }
        if (!$module) {
            $module = $this->loadModule('Homepage');
        }

        // Set the template dir to the module's dir by default (the module is free to change this)
        //$templateEngine->template_dir = 'templates/modules/'.get_class($module); // Default template dir for this module (user is free to change it)
        TemplateEngine::get()->handle()->assign('curModule', get_class($module));
        $module->run(); // Execute the module code
    }

}

?>