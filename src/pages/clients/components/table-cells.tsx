import { Avatar, AvatarFallback, AvatarImage } from '../../../components/ui/avatar';
import type { Client } from '../../../types';

export function ClientCell({ client }: Readonly<{ client: Client }>) {
  return (
    <div className="flex items-center gap-3">
      <Avatar>
        <AvatarImage src={client.img} alt={client.name} />
        <AvatarFallback>
          {client.name.substring(0, 2).toUpperCase()}
        </AvatarFallback>
      </Avatar>
      <div>
        <div className="font-medium">{client.name}</div>
        <span className="text-muted-foreground text-xs">{client.email}</span>
      </div>
    </div>
  );
}

export function StateBadgeCell({ state }: Readonly<{ state: string }>) {
  const badges: Record<string, { bgColor: string; label: string }> = {
    Ativo: { bgColor: 'bg-green-100 text-green-800', label: 'Ativo' },
    Inativo: { bgColor: 'bg-gray-100 text-gray-800', label: 'Inativo' },
    Eliminado: { bgColor: 'bg-red-100 text-red-800', label: 'Eliminado' },
  };
  const badge = badges[state] || { bgColor: 'bg-gray-100 text-gray-800', label: state };

  return (
    <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badge.bgColor}`}>
      {badge.label}
    </span>
  );
}
