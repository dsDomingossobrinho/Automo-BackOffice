import { useEffect, type ReactNode } from 'react';
import { createPortal } from 'react-dom';

interface ModalProps {
  isOpen: boolean;
  onClose: () => void;
  title: string;
  children: ReactNode;
  size?: 'small' | 'medium' | 'large';
  showCloseButton?: boolean;
}

/**
 * Modal Component - Base reusable modal
 * Uses React Portal for overlay rendering
 */
export default function Modal({
  isOpen,
  onClose,
  title,
  children,
  size = 'medium',
  showCloseButton = true,
}: ModalProps) {
  // Close on Escape key
  useEffect(() => {
    const handleEscape = (e: KeyboardEvent) => {
      if (e.key === 'Escape' && isOpen) {
        onClose();
      }
    };

    document.addEventListener('keydown', handleEscape);
    return () => document.removeEventListener('keydown', handleEscape);
  }, [isOpen, onClose]);

  // Prevent body scroll when modal is open
  useEffect(() => {
    if (isOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = 'unset';
    }

    return () => {
      document.body.style.overflow = 'unset';
    };
  }, [isOpen]);

  if (!isOpen) return null;

  const modalContent = (
    <div className="modal-overlay" onClick={onClose}>
      <div
        className={`modal-container modal-${size}`}
        onClick={(e) => e.stopPropagation()}
      >
        {/* Modal Header */}
        <div className="modal-header">
          <h2 className="modal-title">{title}</h2>
          {showCloseButton && (
            <button
              className="modal-close-button"
              onClick={onClose}
              aria-label="Close"
            >
              <i className="fas fa-times"></i>
            </button>
          )}
        </div>

        {/* Modal Body */}
        <div className="modal-body">{children}</div>
      </div>
    </div>
  );

  // Render modal in portal (outside root)
  return createPortal(modalContent, document.body);
}
