import { Bell, Palette, UserCog } from "lucide-react";
import { Outlet } from "react-router-dom";
import { Separator } from "@/components/ui/separator";
import { SidebarNav } from "./components/side-nav";

const sidebarNavItems = [
  {
    title: "Conta",
    href: "/settings",
    icon: <UserCog size={18} />,
  },
  {
    title: "Aparência",
    href: "/settings/appearance",
    icon: <Palette size={18} />,
  },
  {
    title: "Notificações",
    href: "/settings/notifications",
    icon: <Bell size={18} />,
  },
];

export function SettingsPage() {
  return (
    <section>
      <div className="space-y-0.5">
        <h1 className="text-2xl font-bold tracking-tight md:text-3xl">
          Configurações
        </h1>
        <p className="text-muted-foreground">
          Gerencie suas preferências de conta e configurações.
        </p>
      </div>
      <Separator className="my-4 lg:my-6" />
      <div className="flex flex-1 flex-col space-y-2 overflow-hidden md:space-y-2 lg:flex-row lg:space-y-0 lg:space-x-12">
        <aside className="top-0 lg:sticky lg:w-1/5">
          <SidebarNav items={sidebarNavItems} />
        </aside>
        <div className="flex w-full overflow-y-hidden p-1">
          <Outlet />
        </div>
      </div>
    </section>
  );
}
