// Message related types

export interface Message {
  id: string;
  clientId: string;
  clientName?: string;
  agentId?: string;
  agentName?: string;
  subject: string;
  content: string;
  status: MessageStatus;
  priority: MessagePriority;
  channel: MessageChannel;
  createdAt: string;
  updatedAt?: string;
  readAt?: string;
  repliedAt?: string;
  assignedAt?: string;
  tags?: string[];
  attachments?: MessageAttachment[];
}

export const MessageStatus = {
  New: 'new',
  InProgress: 'in_progress',
  Replied: 'replied',
  Closed: 'closed',
  Archived: 'archived',
} as const;

export type MessageStatus = typeof MessageStatus[keyof typeof MessageStatus];

export const MessagePriority = {
  Low: 'low',
  Normal: 'normal',
  High: 'high',
  Urgent: 'urgent',
} as const;

export type MessagePriority = typeof MessagePriority[keyof typeof MessagePriority];

export const MessageChannel = {
  Email: 'email',
  WhatsApp: 'whatsapp',
  Phone: 'phone',
  WebForm: 'web_form',
  Chat: 'chat',
} as const;

export type MessageChannel = typeof MessageChannel[keyof typeof MessageChannel];

export interface MessageAttachment {
  id: string;
  filename: string;
  filesize: number;
  mimeType: string;
  url: string;
}

export interface CreateMessageData {
  clientId: string;
  subject: string;
  content: string;
  priority?: MessagePriority;
  channel?: MessageChannel;
  tags?: string[];
}

export interface UpdateMessageData extends Partial<CreateMessageData> {
  id: string;
  status?: MessageStatus;
  agentId?: string;
}

export interface MessageFilters {
  search?: string;
  status?: MessageStatus;
  priority?: MessagePriority;
  channel?: MessageChannel;
  agentId?: string;
  clientId?: string;
  sortBy?: 'createdAt' | 'updatedAt' | 'priority';
  sortOrder?: 'asc' | 'desc';
  page?: number;
  limit?: number;
}

export interface MessageStats {
  total: number;
  new: number;
  inProgress: number;
  replied: number;
  closed: number;
  byAgent: {
    agentId: string;
    agentName: string;
    total: number;
    new: number;
    inProgress: number;
    replied: number;
    avgResponseTime?: number; // in minutes
  }[];
  byChannel: {
    channel: MessageChannel;
    count: number;
  }[];
  avgResponseTime?: number; // in minutes
}
