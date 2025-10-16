import { useEffect } from 'react';
import { createPortal } from 'react-dom';

export type ToastType = 'success' | 'error' | 'warning' | 'info';

interface ToastProps {
  message: string;
  type?: ToastType;
  isOpen: boolean;
  onClose: () => void;
  duration?: number;
}

/**
 * Toast Notification Component
 * Simple notification system for user feedback
 */
export default function Toast({
  message,
  type = 'info',
  isOpen,
  onClose,
  duration = 3000,
}: ToastProps) {
  useEffect(() => {
    if (isOpen && duration > 0) {
      const timer = setTimeout(() => {
        onClose();
      }, duration);

      return () => clearTimeout(timer);
    }
  }, [isOpen, duration, onClose]);

  if (!isOpen) return null;

  const getIcon = () => {
    switch (type) {
      case 'success':
        return 'fa-check-circle';
      case 'error':
        return 'fa-exclamation-circle';
      case 'warning':
        return 'fa-exclamation-triangle';
      case 'info':
      default:
        return 'fa-info-circle';
    }
  };

  const toastContent = (
    <div className={`toast toast-${type}`} onClick={onClose}>
      <i className={`fas ${getIcon()} toast-icon`}></i>
      <span className="toast-message">{message}</span>
      <button className="toast-close" onClick={onClose}>
        <i className="fas fa-times"></i>
      </button>
    </div>
  );

  return createPortal(toastContent, document.body);
}
