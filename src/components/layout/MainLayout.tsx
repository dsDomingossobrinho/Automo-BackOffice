import { type ReactNode } from 'react';
import Sidebar from './Sidebar';
import Header from './Header';

interface MainLayoutProps {
  children: ReactNode;
}

/**
 * Main Layout Component
 * Wraps dashboard pages with Sidebar and Header
 */
export default function MainLayout({ children }: MainLayoutProps) {
  return (
    <div className="main-layout">
      <Sidebar />
      <div className="main-content-wrapper">
        <Header />
        <main className="main-content">
          {children}
        </main>
      </div>
    </div>
  );
}
