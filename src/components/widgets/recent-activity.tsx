'use client';

import { memo } from 'react';
import { motion } from 'framer-motion';
import { User, Download, Settings, Users } from 'lucide-react';

const activities = [
  {
    action: 'Login do usuário',
    user: 'john@example.com',
    time: 'há 2 min',
    icon: User,
    color: 'text-blue-500',
  },
  {
    action: 'Exportação de dados',
    user: 'admin',
    time: 'há 5 min',
    icon: Download,
    color: 'text-green-500',
  },
  {
    action: 'Configurações atualizadas',
    user: 'admin',
    time: 'há 10 min',
    icon: Settings,
    color: 'text-orange-500',
  },
  {
    action: 'Novo usuário registrado',
    user: 'sarah@example.com',
    time: 'há 15 min',
    icon: Users,
    color: 'text-purple-500',
  },
];

export const RecentActivity = memo(() => {
  return (
    <div className="border-border bg-card/40 rounded-xl border p-6">
      <h3 className="mb-4 text-xl font-semibold">Atividade Recente</h3>
      <div className="space-y-3">
        {activities.map((activity, index) => {
          const Icon = activity.icon;
          return (
            <motion.div
              key={`${index}-10`}
              initial={{ opacity: 0, y: 10 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.1 }}
              className="hover:bg-accent/50 flex items-center gap-3 rounded-lg p-2 transition-colors"
            >
              <div className={`bg-accent/50 rounded-lg p-2`}>
                <Icon className={`h-4 w-4 ${activity.color}`} />
              </div>
              <div className="min-w-0 flex-1">
                <div className="text-sm font-medium">{activity.action}</div>
                <div className="text-muted-foreground truncate text-xs">
                  {activity.user}
                </div>
              </div>
              <div className="text-muted-foreground text-xs">
                {activity.time}
              </div>
            </motion.div>
          );
        })}
      </div>
    </div>
  );
});

RecentActivity.displayName = 'RecentActivity';
