# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Automo-BackOffice** - A production-ready PHP MVC frontend dashboard for automotive business data automation and management. Features a **completely unified modal card design system** implemented in September 2025, with all CRUD operations handled through elegant modal overlays following a consistent 4-level page architecture across all dashboard pages.

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
- **CSS3** with unified modal card design system (24,000+ lines)
- **Unified Design Language**: Professional gradient-based styling with micro-interactions

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
├── assets/css/     # Unified design system (global-design-system.css)
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

## Unified Modal Card System (September 2025)

**Complete UI/UX Overhaul**: All dashboard pages redesigned with consistent modal card interface.

### 4-Level Page Architecture
Every page follows this exact hierarchical structure:

1. **Page Title Section** - Isolated, prominent page identification
2. **Primary Add Button** - Prominent action button with gradient styling
3. **Filters Section** - Search inputs, dropdowns, and filter actions
4. **Data Table Section** - Clean table with action buttons leading to modals

### Modal Card CRUD Pattern
All CRUD operations handled via 4 modal cards per entity:

1. **Create Modal**: Form for adding new items with validation
2. **View Modal**: Read-only display with profile-style layout
3. **Edit Modal**: Editable form with pre-populated data
4. **Delete Modal**: Confirmation dialog with consequence warnings

### Production-Ready Pages
- **Dashboard**: Stats cards, charts, quick actions with Chart.js integration
- **Clients**: Complete client management with modal CRUD operations
- **Finances**: Financial management with export functionality and transaction tracking
- **Invoices**: Invoice management with comprehensive forms and status tracking
- **Messages**: Message management system with modal interface (in progress)
- **Users**: Profile and settings pages with enhanced design (planned)

### Technical Implementation
- **Global CSS**: 24,000+ lines unified design system at `/assets/css/global-design-system.css`
- **JavaScript**: Async/await patterns for API communication
- **Animations**: Smooth transitions, fadeIn/slideInScale effects
- **Responsive**: Mobile-first design with touch-friendly interactions
- **Accessibility**: WCAG compliant with keyboard navigation support

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

**Unified Design System Features:**
- **CSS Variables**: Comprehensive design tokens for consistent theming
- **Gradient Design**: Professional gradient-based visual language
- **Component Library**: Reusable modal, button, form, and table components
- **Animation System**: Smooth transitions with cubic-bezier easing
- **Grid System**: CSS Grid and Flexbox for responsive layouts
- **Status Badges**: Color-coded status indicators with gradient styling

**Enhanced JavaScript Architecture:**
- **Modal Management**: Complete overlay system with backdrop and animations
- **API Communication**: Modern async/await patterns with error handling
- **Form Handling**: CSRF-protected submissions with FormData
- **Event Delegation**: Efficient event handling for dynamic content
- **Keyboard Navigation**: Full accessibility support with Escape key handling
- **State Management**: Client-side state for modal data and interactions

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

**Modal Card Development Guidelines:**
- **Consistent Structure**: All new pages must follow the 4-level hierarchy pattern
- **Modal CRUD**: Use the unified modal card system for all CRUD operations
- **CSS Classes**: Leverage existing classes from `global-design-system.css`
- **JavaScript Patterns**: Follow established async/await and event delegation patterns
- **Responsive Design**: Ensure mobile-first approach with touch-friendly interactions

**Security Requirements:**
- Always validate CSRF tokens in forms
- Escape all output with `e()` helper
- Use parameterized queries (via API)
- Check permissions before sensitive operations
- Add proper null checks for array access (prevent PHP errors)

**Performance Guidelines:**
- **Asset Optimization**: CSS file properly located at `/assets/css/` for asset() function
- **Animation Performance**: Use CSS transforms and opacity for smooth animations
- **Reduced Motion**: Respect user's motion preferences with media queries
- **Loading States**: Provide visual feedback during API operations

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

**Production Status (September 2025): Complete UI/UX Transformation**

This is a production-ready PHP MVC dashboard system featuring a **completely unified modal card design system**. Major achievements:

✅ **Complete Design Overhaul**: All dashboard pages redesigned with consistent 4-level architecture  
✅ **Modal Card System**: Unified CRUD operations via elegant modal overlays  
✅ **24,000+ Lines CSS**: Comprehensive design system with professional gradients  
✅ **Technical Fixes**: Resolved CSS 404 errors and PHP array access issues  
✅ **Performance Optimized**: Fast loading, smooth animations, mobile-first responsive  
✅ **Production Ready**: All major pages (Dashboard, Clients, Finances, Invoices) complete  

**Status Overview:**
- **Frontend**: ✅ **COMPLETE** - Modern, unified interface working perfectly
- **Backend API**: ⚠️ **Needs Attention** - Some endpoints returning 500 errors (backend team)

The system delivers a professional, scalable, and maintainable dashboard experience with modern UI/UX standards.