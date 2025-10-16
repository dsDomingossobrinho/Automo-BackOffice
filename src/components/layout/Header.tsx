import { useAuthStore } from '../../stores/authStore';

/**
 * Header/Navbar Component
 * Top navigation bar for the dashboard
 */
export default function Header() {
  const { user, getUserName, logout } = useAuthStore();

  const handleLogout = () => {
    if (window.confirm('Tem certeza que deseja sair?')) {
      logout();
    }
  };

  return (
    <header className="main-header">
      <div className="header-left">
        <h2 className="header-title">Automo BackOffice</h2>
      </div>

      <div className="header-right">
        {/* User Dropdown */}
        <div className="header-user">
          <div className="header-user-avatar">
            {user?.img ? (
              <img src={user.img} alt={getUserName() || 'User'} />
            ) : (
              <i className="fas fa-user-circle"></i>
            )}
          </div>
          <div className="header-user-info">
            <div className="header-user-name">{getUserName() || user?.email}</div>
            <div className="header-user-role">
              {user?.isBackOffice ? 'Back Office' : 'User'}
            </div>
          </div>
        </div>

        {/* Logout Button */}
        <button className="header-logout" onClick={handleLogout} title="Sair">
          <i className="fas fa-sign-out-alt"></i>
        </button>
      </div>
    </header>
  );
}
