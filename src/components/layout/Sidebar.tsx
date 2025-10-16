import { useState } from 'react';
import { NavLink, useLocation } from 'react-router-dom';
import { useAuthStore } from '../../stores/authStore';

interface MenuItem {
  group?: string;
  to?: string;
  label?: string;
  icon?: string;
  title?: string;
  children?: MenuItem[];
}

/**
 * Sidebar Navigation Component
 * Migrated from PHP app/Core/View.php getMenus()
 */
export default function Sidebar() {
  const location = useLocation();
  const { user, logout } = useAuthStore();
  const [expandedMenus, setExpandedMenus] = useState<{ [key: string]: boolean }>({});
  const [isMobileOpen, setIsMobileOpen] = useState(false);

  // Menu items from PHP
  const menuItems: MenuItem[] = [
    { group: 'Main' },
    { to: '/dashboard', label: 'Dashboard', icon: 'tachometer-alt' },

    { group: 'Param. & Estatística' },
    { to: '/accounts', label: 'Administradores', icon: 'users-cog' },

    { group: 'Estatísticas Gerais' },
    { to: '/clients', label: 'Clientes', icon: 'users' },
    {
      to: '', label: 'Mensagens', icon: 'comments',
      children: [
        { to: '/messages', label: 'Enviadas (Total)', icon: 'paper-plane' },
        { to: '/messages/by-client', label: 'Por Cliente', icon: 'user-tag' },
      ],
    },

    { group: 'Estatísticas por Agente' },
    {
      to: '', label: 'Mensagens', icon: 'chart-line',
      children: [
        { to: '/statistics/engagement', label: 'Por Engagement', icon: 'comments' },
        { to: '/statistics/demographics', label: 'Demográficas', icon: 'chart-bar' },
        { to: '/statistics/comparison', label: 'Comparativas', icon: 'exchange-alt' },
        { group: 'Estatísticas por Agente' },
        { to: '/messages/status', label: 'Por Status', icon: 'check-circle' },
        { to: '/messages/filter', label: 'Por Filtros', icon: 'filter' },
        { to: '/messages/conversion', label: 'Por Conversão', icon: 'chart-pie' },
        { to: '/messages/by-client/all', label: 'Por Cliente (Total)', icon: 'chart-bar' },
      ],
    },

    { group: 'Param. & Financeiro' },
    {
      to: '', label: 'Financeiro', icon: 'chart-area',
      children: [
        { to: '/finances', label: 'Total Facturado', icon: 'money-bill-wave' },
        { to: '/finances/monthly', label: 'Total Mensal', icon: 'calendar-month' },
        { to: '/finances/daily', label: 'Total Diário', icon: 'calendar-day' },
        { to: '/finances/weekly', label: 'Total Semanal', icon: 'calendar-week' },
      ],
    },
    {
      to: '', label: 'Documentos', icon: 'file-invoice-dollar',
      children: [
        { to: '/invoices', label: 'RPP', title: 'Recibo, Pagamentos e Planos', icon: 'receipt' },
        { to: '/invoices/receipts', label: 'Visualizar Recibos', icon: 'file-pdf' },
        { to: '/invoices/planos', label: 'Planos', icon: 'clipboard-list' },
      ],
    },
  ];

  const toggleMenu = (label: string) => {
    setExpandedMenus(prev => ({
      ...prev,
      [label]: !prev[label]
    }));
  };

  const isActive = (path: string) => {
    return location.pathname === path;
  };

  const handleLogout = () => {
    if (window.confirm('Tem certeza que deseja sair?')) {
      logout();
    }
  };

  return (
    <>
      {/* Mobile Toggle Button */}
      <button
        className="sidebar-mobile-toggle"
        onClick={() => setIsMobileOpen(!isMobileOpen)}
      >
        <i className="fas fa-bars"></i>
      </button>

      {/* Sidebar */}
      <aside className={`sidebar ${isMobileOpen ? 'sidebar-mobile-open' : ''}`}>
        {/* Sidebar Header */}
        <div className="sidebar-header">
          <div className="sidebar-brand">
            <img src="/logo.png" alt="Automo Logo" className="sidebar-logo" />
            <span>Automo</span>
          </div>
        </div>

        {/* Navigation */}
        <nav className="sidebar-nav">
          {menuItems.map((item, index) => {
            // Group Header
            if (item.group) {
              return (
                <div key={index} className="sidebar-group">
                  {item.group}
                </div>
              );
            }

            // Menu with children
            if (item.children) {
              const isExpanded = expandedMenus[item.label || ''];
              return (
                <div key={index} className="sidebar-item-wrapper">
                  <button
                    className={`sidebar-item sidebar-item-expandable ${isExpanded ? 'expanded' : ''}`}
                    onClick={() => toggleMenu(item.label || '')}
                  >
                    <i className={`fas fa-${item.icon}`}></i>
                    <span>{item.label}</span>
                    <i className={`fas fa-chevron-down sidebar-item-arrow ${isExpanded ? 'rotated' : ''}`}></i>
                  </button>
                  {isExpanded && (
                    <div className="sidebar-submenu">
                      {item.children.map((child, childIndex) => (
                        <NavLink
                          key={childIndex}
                          to={child.to || '#'}
                          className={`sidebar-subitem ${isActive(child.to || '') ? 'active' : ''}`}
                          title={child.title}
                        >
                          <i className={`fas fa-${child.icon}`}></i>
                          <span>{child.label}</span>
                        </NavLink>
                      ))}
                    </div>
                  )}
                </div>
              );
            }

            // Regular menu item
            return (
              <NavLink
                key={index}
                to={item.to || '#'}
                className={`sidebar-item ${isActive(item.to || '') ? 'active' : ''}`}
                title={item.title}
              >
                <i className={`fas fa-${item.icon}`}></i>
                <span>{item.label}</span>
              </NavLink>
            );
          })}
        </nav>

        {/* Logout Button */}
        <div className="sidebar-footer">
          <button className="sidebar-logout" onClick={handleLogout}>
            <i className="fas fa-sign-out-alt"></i>
            <span>Sair</span>
          </button>
        </div>
      </aside>

      {/* Mobile Overlay */}
      {isMobileOpen && (
        <div
          className="sidebar-overlay"
          onClick={() => setIsMobileOpen(false)}
        ></div>
      )}
    </>
  );
}
