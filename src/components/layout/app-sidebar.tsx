import {
  BarChart3,
  Bot,
  ChevronRight,
  LayoutDashboard,
  Settings,
  Settings2,
  Users,
} from "lucide-react";
import { memo } from "react";
import { Link } from "react-router-dom";
import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from "@/components/ui/collapsible";
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarRail,
  useSidebar,
} from "@/components/ui/sidebar";
import { cn } from "@/lib/utils";

const mainMenu = [
  { title: "Dashboard", icon: LayoutDashboard, href: "/dashboard" },
  { title: "Administradores", icon: Users, href: "/accounts" },
  { title: "Clientes", icon: Users, href: "/clients" },
  { title: "Agente AI", icon: Bot, href: "/agent" },
  { title: "Financeiro", icon: BarChart3, href: "/finances" },
  {
    title: "Parametros",
    icon: Settings2,
    items: [
      { title: "Cargos", icon: Settings, href: "/parameters/roles" },
      {
        title: "Tipos de contas",
        icon: Settings,
        href: "/parameters/accounts-type",
      },
      { title: "Paises", icon: Settings, href: "/parameters/countries" },
      { title: "Provincias", icon: Settings, href: "/parameters/provinces" },
      { title: "Planos", icon: Settings, href: "/parameters/plans" },
      { title: "Promoções", icon: Settings, href: "/parameters/promotions" },
      { title: "Estados", icon: Settings, href: "/parameters/states" },
    ],
  },
];

export const AppSidebar = memo(() => {
  const { state } = useSidebar();
  return (
    <Sidebar collapsible="icon" className="bg-slate-900">
      <SidebarHeader>
        <SidebarMenu>
          <SidebarMenuItem>
            <SidebarMenuButton size="lg" asChild>
              <section>
                <img src="/logo.png" alt="Automo logo" className="size-12" />
                <span className="font-semibold text-xl">Automo</span>
              </section>
            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarHeader>

      <SidebarContent>
        <SidebarGroup>
          <SidebarGroupLabel>Navegação</SidebarGroupLabel>
          <SidebarGroupContent>
            <SidebarMenu>
              {mainMenu.map((item) => {
                const Icon = item.icon;

                // Se o item tem subitems, renderiza como Collapsible
                if (item.items) {
                  return (
                    <Collapsible key={item.title} className="group/collapsible">
                      <SidebarMenuItem>
                        <CollapsibleTrigger asChild>
                          <SidebarMenuButton
                            size="lg"
                            tooltip={item.title}
                            className={cn(
                              "flex items-center",
                              state === "collapsed" && "justify-center",
                            )}
                          >
                            <Icon />
                            {state !== "collapsed" && (
                              <>
                                <span>{item.title}</span>
                                <ChevronRight className="ml-auto transition-transform group-data-[state=open]/collapsible:rotate-90" />
                              </>
                            )}
                          </SidebarMenuButton>
                        </CollapsibleTrigger>
                        <CollapsibleContent>
                          <SidebarMenu>
                            {item.items.map((subItem) => (
                              <SidebarMenuItem key={subItem.href}>
                                <SidebarMenuButton asChild>
                                  <Link to={subItem.href}>
                                    {state !== "collapsed" && (
                                      <span>{subItem.title}</span>
                                    )}
                                  </Link>
                                </SidebarMenuButton>
                              </SidebarMenuItem>
                            ))}
                          </SidebarMenu>
                        </CollapsibleContent>
                      </SidebarMenuItem>
                    </Collapsible>
                  );
                }

                return (
                  <SidebarMenuItem key={item.href}>
                    <SidebarMenuButton size="lg" asChild>
                      <Link
                        to={item.href}
                        className={cn(
                          "flex items-center",
                          state === "collapsed" && "justify-center",
                        )}
                      >
                        <Icon />
                        {state !== "collapsed" && <span>{item.title}</span>}
                      </Link>
                    </SidebarMenuButton>
                  </SidebarMenuItem>
                );
              })}
            </SidebarMenu>
          </SidebarGroupContent>
        </SidebarGroup>
      </SidebarContent>

      <SidebarFooter>
        <SidebarMenu>
          <SidebarMenuItem>
            <SidebarMenuButton size="lg" asChild>
              <Link
                to="/settings"
                className={cn(
                  "flex items-center",
                  state === "collapsed" && "justify-center",
                )}
              >
                <Settings />
                {state !== "collapsed" && <span>Configurações</span>}
              </Link>
            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarFooter>
      <SidebarRail />
    </Sidebar>
  );
});

AppSidebar.displayName = "AppSidebar";
