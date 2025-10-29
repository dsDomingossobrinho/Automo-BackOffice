import { ContentSection } from "../components/content-section";
import { NotificationsForm } from "./notification-form";

export function SettingsNotificationsPage() {
  return (
    <ContentSection
      title='Notificações'
      desc='Gerencie suas preferências de notificação e métodos de comunicação.'
    >
      <NotificationsForm />
    </ContentSection>
  )
}