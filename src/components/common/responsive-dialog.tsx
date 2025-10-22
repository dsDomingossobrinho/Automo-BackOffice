import type { LucideIcon } from "lucide-react";
import { Loader2 } from "lucide-react";
import type * as React from "react";
import { Button } from "@/components/ui/button";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import {
  Drawer,
  DrawerContent,
  DrawerDescription,
  DrawerFooter,
  DrawerHeader,
  DrawerTitle,
} from "@/components/ui/drawer";
import { useMediaQuery } from "@/hooks/use-mobile";
import { cn } from "@/lib/utils";

export interface DialogAction {
  label: string;
  onClick: () => void;
  variant?:
  | "default"
  | "destructive"
  | "outline"
  | "secondary"
  | "ghost"
  | "link";
  disabled?: boolean;
  loading?: boolean;
  icon?: LucideIcon;
  className?: string;
}

export interface ResponsiveDialogProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  title: string;
  description?: string;
  children: React.ReactNode;
  actions?: DialogAction[];
  footer?: React.ReactNode; // Mantém suporte para footer customizado
  className?: string;
}

export function ResponsiveDialog({
  open,
  onOpenChange,
  title,
  description,
  children,
  actions,
  footer,
  className = "",
}: Readonly<ResponsiveDialogProps>) {
  const isDesktop = useMediaQuery("(min-width: 768px)");

  // Render footer com botões automáticos ou customizado
  const footerContent =
    footer ||
    (actions && actions.length > 0 && (
      <div className="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 w-full">
        {actions.map((action) => {
          const Icon = action.icon;
          return (
            <Button
              key={action.label}
              type="button"
              variant={action.variant || "default"}
              onClick={action.onClick}
              disabled={action.disabled || action.loading}
              className={cn(action.className)}
            >
              {action.loading ? (
                <>
                  <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                  {action.label}
                </>
              ) : (
                <>
                  {Icon && <Icon className="mr-2 h-4 w-4" />}
                  {action.label}
                </>
              )}
            </Button>
          );
        })}
      </div>
    ));

  if (isDesktop) {
    return (
      <Dialog open={open} onOpenChange={onOpenChange}>
        <DialogContent className={cn("sm:max-w-[600px]", className)}>
          <DialogHeader>
            <DialogTitle>{title}</DialogTitle>
            {description && (
              <DialogDescription>{description}</DialogDescription>
            )}
          </DialogHeader>
          <div className="max-h-[60vh] overflow-y-auto px-1">{children}</div>
          {footerContent && <DialogFooter>{footerContent}</DialogFooter>}
        </DialogContent>
      </Dialog>
    );
  }

  return (
    <Drawer open={open} onOpenChange={onOpenChange}>
      <DrawerContent className={cn(className)}>
        <DrawerHeader className="text-left">
          <DrawerTitle>{title}</DrawerTitle>
          {description && <DrawerDescription>{description}</DrawerDescription>}
        </DrawerHeader>
        <div className="max-h-[70vh] overflow-y-auto px-4">{children}</div>
        {footerContent && <DrawerFooter>{footerContent}</DrawerFooter>}
      </DrawerContent>
    </Drawer>
  );
}
