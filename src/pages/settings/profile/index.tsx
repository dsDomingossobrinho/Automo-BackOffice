import { ContentSection } from '../components/content-section'
import { ProfileForm } from './profile-form'

export function SettingsProfilePage() {
  return (
    <ContentSection
      title='Conta'
      desc='Atualize as informações do seu perfil e configure suas preferências de conta.'
    >
      <ProfileForm />
    </ContentSection>
  )
}