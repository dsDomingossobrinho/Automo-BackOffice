export interface Agent {
  id: number;
  name: string;
  stateId?: number;
  state?: string;
}

export interface MergedAgent {
  id: number;
  name: string;
  state: string;
  replied: number;
  total: number;
}

export interface AgentFilters {
  search?: string;
  state?: string;
}
