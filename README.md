# Automo BackOffice

Frontend dashboard application for the Automo automotive business management system.

## 🚀 Overview

**Automo BackOffice** is a comprehensive PHP MVC dashboard frontend that provides data automation and management capabilities for automotive businesses. It features a clean, responsive design with full CRUD operations, authentication system, and seamless integration with the Automo Backend API.

## 🏗️ Architecture

- **Framework**: PHP 8.2+ with custom MVC architecture
- **Frontend**: Modern responsive CSS with JavaScript
- **Authentication**: JWT-based with OTP validation
- **API Integration**: RESTful API client for backend communication
- **Deployment**: Docker containerization

## 📋 Features

### ✨ Core Features
- **Multi-step Authentication**: Login with OTP verification
- **Dynamic Dashboard**: Real-time statistics and charts
- **Responsive Design**: Desktop, tablet, and mobile support
- **Dynamic Sidebar Menu**: Hierarchical navigation with groups
- **Full CRUD Operations**: For all entities with data tables
- **Search & Filtering**: Real-time search and advanced filters
- **Data Export**: CSV and JSON export capabilities
- **Permissions System**: Role-based access control
- **File Upload**: Secure file handling
- **Error Handling**: Comprehensive error pages and logging

### 📊 Dashboard Modules
- **Clientes (Clients)**: Client management with status tracking
- **Mensagens (Messages)**: Message tracking and statistics
- **Financeiro (Financial)**: Revenue tracking and reporting
- **Documentos (Documents)**: Invoice and document management
- **Contas & Permissões (Accounts)**: User and permission management

## 🛠️ Technology Stack

- **Backend**: PHP 8.2+
- **Web Server**: Apache with mod_rewrite
- **Caching**: Redis (optional)
- **Frontend Assets**: 
  - CSS3 with custom framework
  - Vanilla JavaScript with modern features
  - Font Awesome icons
  - Chart.js for data visualization
- **Container**: Docker with multi-stage builds

## 🚀 Quick Start

### Prerequisites
- Docker and Docker Compose
- Git

### Installation

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd Automo-BackOffice
   ```

2. **Configure environment:**
   ```bash
   cp .env.example .env
   # Edit .env with your settings
   ```

3. **Start with Docker Compose:**
   ```bash
   docker-compose up -d
   ```

4. **Access the application:**
   - BackOffice: http://localhost:3000
   - Backend API: http://localhost:8080 (must be running)

### Manual Installation (Without Docker)

1. **Requirements:**
   - PHP 8.2+
   - Apache with mod_rewrite
   - Composer (optional)

2. **Setup:**
   ```bash
   # Configure virtual host to point to /public directory
   # Ensure mod_rewrite is enabled
   # Set appropriate permissions
   chmod -R 755 storage/
   ```

## 🐳 Docker Deployment

### Development Environment

```bash
# Start all services
docker-compose up -d

# View logs
docker-compose logs -f backoffice-app

# Stop services
docker-compose down
```

### Production Environment

```bash
# Build and run with production profile
docker-compose --profile production up -d

# This includes Nginx reverse proxy on port 8081
```

### Port Configuration

The system is designed to work alongside the Automo Backend:

- **Backend Services** (existing):
  - PostgreSQL: `5432`
  - Backend API: `8080`
  - PgAdmin: `8082`

- **BackOffice Services** (new):
  - BackOffice App: `3000`
  - Redis Cache: `6379`
  - Nginx Proxy: `8081` (production only)

## 🔧 Configuration

### Environment Variables

Key configuration options in `.env`:

```env
# Application
DEBUG_MODE=true
BASE_URL=http://localhost:3000
API_BASE_URL=http://localhost:8080

# Security
SESSION_LIFETIME=14400
CSRF_TOKEN_NAME=_token

# File Upload
UPLOAD_MAX_SIZE=5242880
UPLOAD_ALLOWED_TYPES=jpg,jpeg,png,pdf,doc,docx
```

### API Integration

The system communicates with the Automo Backend API:

- **Authentication**: JWT tokens with automatic refresh
- **Error Handling**: Graceful degradation when API is unavailable
- **Endpoints**: Full CRUD operations for all entities
- **File Upload**: Multipart form support

## 📁 Project Structure

```
Automo-BackOffice/
├── app/
│   ├── Controllers/        # MVC Controllers
│   ├── Core/              # Framework core classes
│   ├── Models/            # Data models
│   └── Views/             # Template files
│       ├── layouts/       # Layout templates
│       ├── auth/          # Authentication views
│       ├── dashboard/     # Dashboard views
│       └── clients/       # Client CRUD views
├── config/                # Configuration files
├── helpers/               # Helper functions
├── public/                # Public web directory
│   ├── assets/           # CSS, JS, images
│   └── index.php         # Front controller
├── docker/               # Docker configuration
├── storage/              # Logs and uploads
└── docker-compose.yml
```

## 🎨 UI/UX Features

### Design System
- **Color Palette**: Professional blue-based theme
- **Typography**: Clean, readable fonts
- **Icons**: Font Awesome 6 integration
- **Responsive Grid**: Custom CSS grid system
- **Components**: Reusable UI components

### User Experience
- **Navigation**: Intuitive sidebar with breadcrumbs
- **Forms**: Real-time validation and error handling
- **Tables**: Sortable columns with search and filtering
- **Modals**: Confirmation dialogs for destructive actions
- **Notifications**: Toast-style feedback messages
- **Loading States**: Visual feedback for async operations

## 🔒 Security

### Authentication
- **JWT Integration**: Secure token-based authentication
- **OTP Verification**: Two-factor authentication support
- **Session Management**: Secure session handling
- **Password Security**: Backend password validation

### Protection Measures
- **CSRF Protection**: Token-based CSRF protection
- **XSS Prevention**: Input sanitization and output escaping
- **SQL Injection**: Parameterized queries via API
- **File Upload Security**: Type and size validation
- **Security Headers**: Comprehensive HTTP security headers

## 📊 Dashboard Features

### Statistics Dashboard
- **Client Metrics**: Total, active, and new client counts
- **Revenue Tracking**: Daily, weekly, monthly revenue
- **Message Statistics**: Sent, read, and response rates
- **Visual Charts**: Interactive charts with Chart.js
- **Recent Activity**: Real-time activity feed
- **Quick Actions**: Common task shortcuts

### Data Management
- **Advanced Search**: Multi-field search capabilities
- **Filtering**: Dynamic filtering by multiple criteria
- **Pagination**: Efficient data pagination
- **Bulk Operations**: Select and perform bulk actions
- **Data Export**: Export to CSV and JSON formats
- **Sorting**: Multi-column sorting capabilities

## 🧪 Development

### Code Standards
- **PSR Standards**: Following PSR-4 autoloading
- **MVC Pattern**: Clean separation of concerns
- **Security First**: Input validation and output escaping
- **Error Handling**: Comprehensive error management
- **Documentation**: Inline documentation and comments

### Customization
- **Theming**: Easy color and style customization
- **Menu Structure**: Simple menu configuration
- **Permissions**: Flexible permission system
- **API Endpoints**: Easy endpoint configuration
- **Validation Rules**: Customizable validation rules

## 🔧 Troubleshooting

### Common Issues

1. **API Connection Failed:**
   ```bash
   # Check if backend is running
   curl http://localhost:8080/actuator/health
   
   # Check network connectivity
   docker network ls
   ```

2. **Permission Denied:**
   ```bash
   # Fix file permissions
   sudo chown -R www-data:www-data storage/
   sudo chmod -R 775 storage/
   ```

3. **Assets Not Loading:**
   ```bash
   # Check Apache mod_rewrite
   sudo a2enmod rewrite
   sudo service apache2 restart
   ```

### Debug Mode

Enable debug mode in `.env`:
```env
DEBUG_MODE=true
```

This provides:
- Detailed error messages
- API request/response logging
- Performance metrics
- Debug toolbar (if enabled)

## 📈 Performance

### Optimization Features
- **Asset Compression**: Gzip compression for static files
- **Caching**: Redis-based session and data caching
- **Lazy Loading**: Efficient data loading strategies
- **CDN Ready**: External asset loading support
- **Minification**: CSS and JS optimization ready

### Monitoring
- **Health Checks**: Docker health check endpoints
- **Error Logging**: Comprehensive error logging
- **Performance Metrics**: Request timing and memory usage
- **API Monitoring**: Backend API connectivity tracking

## 🤝 Contributing

### Development Workflow
1. Create feature branch
2. Implement changes following MVC pattern
3. Test thoroughly with backend integration
4. Update documentation
5. Submit pull request

### Code Style
- Follow PSR standards
- Use meaningful variable names
- Add inline documentation
- Implement error handling
- Write secure code

## 📝 License

This project is proprietary software developed for Automo business management.

## 📞 Support

For technical support or questions:
- Check the troubleshooting section
- Review the API documentation
- Contact the development team

---

**Developed with ❤️ for Automo - Automotive Business Management**