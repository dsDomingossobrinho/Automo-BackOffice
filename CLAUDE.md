# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Automo-BackOffice** - A comprehensive PHP MVC frontend dashboard for automotive business data automation and management. This system provides a modern, responsive interface for managing clients, messages, financial data, and administrative functions.

## Commands

### Development
```bash
# Start development server with Docker
docker-compose up -d

# View application logs
docker-compose logs -f backoffice-app

# Stop services
docker-compose down

# Access application
# http://localhost:3000
```

### Without Docker
```bash
# Ensure Apache with mod_rewrite is configured
# Point document root to /public directory
# Set permissions: chmod -R 755 storage/
```

## Architecture Overview

**Technology Stack:**
- **PHP 8.2+** with custom MVC framework
- **Apache** with mod_rewrite for clean URLs
- **Redis** for session storage and caching (optional)
- **Docker** containerization
- **JavaScript** (vanilla) with modern features
- **CSS3** with custom responsive framework

**Project Structure:**
```
app/
├── Controllers/     # MVC Controllers (AuthController, DashboardController, etc.)
├── Core/           # Framework core (Router, Controller, Model, View, Auth, ApiClient)
├── Models/         # Data models for API communication
└── Views/          # Template files with layouts and components
config/             # Configuration and routing
helpers/            # Global helper functions
public/             # Web root with assets (CSS, JS, images)
docker/             # Docker configuration files
```

## Authentication System

**Multi-step Authentication Flow:**
1. **Login**: User enters credentials (`/login`)
2. **OTP Request**: System requests OTP from backend API
3. **OTP Verification**: User enters 6-digit code (`/otp`)
4. **JWT Token**: Backend returns JWT token for session

**Key Components:**
- `AuthController`: Handles login/logout flow
- `Auth` class: JWT token management and permission checking
- Session management with secure cookies
- Integration with backend `/auth/login/backoffice/request-otp` endpoint

## API Integration

**Backend Communication:**
- **Base URL**: Configurable via `API_BASE_URL` environment variable
- **Authentication**: JWT Bearer token in Authorization header
- **Error Handling**: Graceful degradation when backend unavailable
- **Timeout**: Configurable request timeout
- **Security**: CSRF protection and input validation

**ApiClient Methods:**
- `get()`, `post()`, `put()`, `delete()` - Basic HTTP methods
- `authenticatedRequest()` - Requests with JWT token
- `uploadFile()` - Multipart file uploads
- `healthCheck()` - Backend connectivity test

## Dynamic Sidebar Menu

**Menu Structure** (defined in `View.php`):
```php
$menus = [
    ['group' => 'Main'],
    ['to' => '/dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
    
    ['group' => 'Param. & Estatística'],
    ['to' => '/accounts', 'label' => 'Contas & Permissões', 'icon' => 'group'],
    // ... hierarchical menu with children arrays
];
```

**Features:**
- **Groups**: Visual separators for menu sections
- **Icons**: Font Awesome 6 integration
- **Submenus**: Expandable child menus
- **Active States**: Automatic active link highlighting
- **Responsive**: Collapsible on mobile devices

## CRUD System Pattern

**Every entity follows this pattern:**

1. **Controller Structure:**
   - `index()` - List with search/filter
   - `create()` - Show create form
   - `store()` - Handle create submission
   - `show($id)` - View single item
   - `edit($id)` - Show edit form
   - `update($id)` - Handle update submission
   - `delete($id)` - Soft delete item

2. **View Templates:**
   - `index.php` - Data table with search, filters, pagination
   - `create.php` - Form for new items
   - `edit.php` - Form for editing
   - `show.php` - Detail view

3. **Features:**
   - **Search**: Real-time search across multiple fields
   - **Filtering**: Dropdown filters (state, type, etc.)
   - **Pagination**: Configurable page sizes
   - **Sorting**: Sortable table columns
   - **Bulk Actions**: Select multiple items for bulk operations
   - **Export**: CSV/JSON export functionality
   - **Permissions**: Role-based access control

## Permission System

**Role-Based Access Control:**
- **Admin (ID: 1)**: Full access to all features
- **User (ID: 2)**: Basic access
- **Agent (ID: 3)**: Client and message management
- **Manager (ID: 4)**: Team and report access

**Usage in Controllers:**
```php
// Check permissions before allowing access
if (!$this->auth->hasPermission('create_clients')) {
    $this->setFlash('errors', ['Sem permissão']);
    $this->redirect('/clients');
}
```

**Available Permission Methods:**
- `hasPermission($permission)` - Check specific permission
- `isAdmin()`, `isAgent()`, `isManager()` - Role checks
- `hasRole($roleId)` - Check specific role ID

## Frontend Architecture

**CSS Framework:**
- Custom responsive grid system
- CSS variables for theming
- Component-based styling
- Mobile-first approach
- Professional color scheme

**JavaScript Features:**
- **AutomoApp Class**: Main application controller
- **Form Validation**: Real-time client-side validation
- **AJAX Utilities**: API request helpers
- **Search**: Debounced search functionality
- **Notifications**: Toast-style feedback system
- **Modal Management**: Dynamic modal handling
- **Table Enhancement**: Sorting and filtering

## Security Features

**Input Security:**
- **CSRF Protection**: Token-based protection for forms
- **XSS Prevention**: Output escaping with `e()` helper
- **Input Validation**: Server-side validation
- **File Upload Security**: Type and size restrictions
- **Session Security**: HTTPOnly and Secure cookies

**HTTP Security Headers:**
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: DENY`
- `X-XSS-Protection: 1; mode=block`
- `Strict-Transport-Security`
- `Content-Security-Policy`

## Error Handling

**Error Pages:**
- `404.php` - Page not found
- `500.php` - Internal server error
- Graceful API error handling
- Debug mode for development

**Logging:**
- API request/response logging in debug mode
- Error logging to storage/logs/
- Performance metrics tracking

## Docker Configuration

**Services:**
- **backoffice-app**: Main PHP application (port 3000)
- **cache**: Redis for sessions and caching (port 6379)
- **nginx**: Production reverse proxy (port 8081)

**Port Allocation** (no conflicts with backend):
- Backend API: 8080
- PgAdmin: 8082
- **BackOffice: 3000** ← New
- Redis: 6379
- Nginx: 8081 (production)

## Development Guidelines

**MVC Best Practices:**
- Controllers handle HTTP requests and responses only
- Models handle data and API communication
- Views contain presentation logic only
- Use helper functions for common operations
- Follow PSR-4 autoloading standards

**Security Requirements:**
- Always validate CSRF tokens in forms
- Escape all output with `e()` helper
- Use parameterized queries (via API)
- Check permissions before sensitive operations
- Sanitize file uploads

**Code Organization:**
- One class per file
- Meaningful class and method names
- Inline documentation for complex logic
- Consistent error handling
- Environment-specific configuration

## Environment Configuration

**Key Environment Variables:**
```env
DEBUG_MODE=true                    # Enable debug features
BASE_URL=http://localhost:3000     # Frontend base URL
API_BASE_URL=http://localhost:8080 # Backend API URL
SESSION_LIFETIME=14400             # Session timeout (4 hours)
UPLOAD_MAX_SIZE=5242880           # Max file upload size
```

**Development vs Production:**
- Debug mode shows detailed errors and API logs
- Production mode enables caching and security headers
- Environment-specific Docker profiles available

---

**This is a production-ready PHP MVC dashboard system with comprehensive CRUD operations, authentication, and modern UI/UX patterns. The system is designed for scalability, security, and maintainability.**