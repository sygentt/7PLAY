<?php

namespace App\Constants;

/**
 * Admin Dashboard Icons Constants
 * 
 * Kelas ini menyimpan semua konstanta icon yang digunakan di admin dashboard
 * untuk memudahkan maintenance dan konsistensi penggunaan icons.
 */
class AdminIcons
{
    // ========================
    // SIDEBAR NAVIGATION ICONS
    // ========================
    public const DASHBOARD = 'squares-2x2';
    public const CITIES = 'building-office-2';
    public const CINEMAS = 'building-storefront'; 
    public const CINEMA_HALLS = 'rectangle-group';
    public const MOVIES = 'film';
    public const SHOWTIMES = 'calendar-days';
    public const ORDERS = 'shopping-bag';
    public const USERS = 'users';
    public const VOUCHERS = 'ticket';
    public const REPORTS = 'chart-bar';
    public const SETTINGS = 'cog-6-tooth';

    // ========================
    // ACTION BUTTON ICONS
    // ========================
    public const ADD = 'plus';
    public const EDIT = 'pencil-square';
    public const DELETE = 'trash';
    public const VIEW = 'eye';
    public const SAVE = 'check';
    public const CANCEL = 'x-mark';
    public const SEARCH = 'magnifying-glass';
    public const FILTER = 'funnel';
    public const EXPORT = 'arrow-down-tray';
    public const IMPORT = 'arrow-up-tray';
    public const REFRESH = 'arrow-path';
    public const DOWNLOAD = 'document-arrow-down';
    public const UPLOAD = 'document-arrow-up';

    // ========================
    // STATUS INDICATOR ICONS
    // ========================
    public const SUCCESS = 'check-circle';
    public const ERROR = 'x-circle';
    public const WARNING = 'exclamation-triangle';
    public const INFO = 'information-circle';
    public const ACTIVE = 'check-badge';
    public const INACTIVE = 'x-mark';
    public const PENDING = 'clock';

    // ========================
    // FORM FIELD ICONS
    // ========================
    public const EMAIL = 'envelope';
    public const PHONE = 'phone';
    public const PASSWORD = 'lock-closed';
    public const CALENDAR = 'calendar-days';
    public const LOCATION = 'map-pin';
    public const IMAGE = 'photo';
    public const FILE = 'document';
    public const TEXT = 'document-text';
    public const NUMBER = 'hashtag';

    // ========================
    // NAVIGATION ICONS
    // ========================
    public const ARROW_LEFT = 'arrow-left';
    public const ARROW_RIGHT = 'arrow-right';
    public const ARROW_UP = 'arrow-up';
    public const ARROW_DOWN = 'arrow-down';
    public const CHEVRON_LEFT = 'chevron-left';
    public const CHEVRON_RIGHT = 'chevron-right';
    public const CHEVRON_UP = 'chevron-up';
    public const CHEVRON_DOWN = 'chevron-down';

    // ========================
    // MENU & UI ICONS
    // ========================
    public const MENU = 'bars-3';
    public const MENU_ALT = 'bars-3-bottom-left';
    public const CLOSE = 'x-mark';
    public const DOTS_VERTICAL = 'ellipsis-vertical';
    public const DOTS_HORIZONTAL = 'ellipsis-horizontal';

    // ========================
    // SPECIFIC BUSINESS ICONS
    // ========================
    
    // Cinema related
    public const SEAT = 'squares-plus';
    public const SCREEN = 'rectangle-stack';
    public const PROJECTOR = 'camera';
    
    // Movie related  
    public const PLAY = 'play';
    public const PAUSE = 'pause';
    public const TRAILER = 'play-circle';
    public const RATING = 'star';
    
    // Order related
    public const PAYMENT = 'credit-card';
    public const RECEIPT = 'receipt-refund';
    public const QR_CODE = 'qr-code';
    
    // User related
    public const PROFILE = 'user-circle';
    public const ADMIN = 'shield-check';
    public const CUSTOMER = 'user';
    
    // Analytics & Reports
    public const ANALYTICS = 'chart-pie';
    public const TRENDING_UP = 'arrow-trending-up';
    public const TRENDING_DOWN = 'arrow-trending-down';
    
    // ========================
    // HELPER METHODS
    // ========================
    
    /**
     * Get icon name with module prefix for better organization
     */
    public static function getModuleIcon(string $module): string
    {
        $moduleIcons = [
            'dashboard' => self::DASHBOARD,
            'cities' => self::CITIES,
            'cinemas' => self::CINEMAS,
            'cinema-halls' => self::CINEMA_HALLS,
            'movies' => self::MOVIES,
            'showtimes' => self::SHOWTIMES,
            'orders' => self::ORDERS,
            'users' => self::USERS,
            'vouchers' => self::VOUCHERS,
            'reports' => self::REPORTS,
            'settings' => self::SETTINGS,
        ];

        return $moduleIcons[$module] ?? self::DASHBOARD;
    }

    /**
     * Get action icon by action type
     */
    public static function getActionIcon(string $action): string
    {
        $actionIcons = [
            'create' => self::ADD,
            'edit' => self::EDIT,
            'update' => self::SAVE,
            'delete' => self::DELETE,
            'show' => self::VIEW,
            'index' => self::VIEW,
            'search' => self::SEARCH,
            'filter' => self::FILTER,
            'export' => self::EXPORT,
            'import' => self::IMPORT,
            'refresh' => self::REFRESH,
        ];

        return $actionIcons[$action] ?? self::VIEW;
    }

    /**
     * Get status icon by status type
     */
    public static function getStatusIcon(string $status): string
    {
        $statusIcons = [
            'active' => self::ACTIVE,
            'inactive' => self::INACTIVE,
            'pending' => self::PENDING,
            'success' => self::SUCCESS,
            'error' => self::ERROR,
            'warning' => self::WARNING,
            'info' => self::INFO,
        ];

        return $statusIcons[$status] ?? self::INFO;
    }
}
