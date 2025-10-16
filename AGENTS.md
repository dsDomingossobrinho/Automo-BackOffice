# Automo BackOffice - Instruções de Desenvolvimento

## 📋 Visão Geral do Projeto

Este é o BackOffice do sistema Automo, desenvolvido em React + TypeScript com Vite. O projeto segue uma arquitetura moderna baseada em componentes reutilizáveis e hooks personalizados.

## 🏗️ Arquitetura do Projeto

### Estrutura de Pastas

```
src/
├── assets/          # Recursos estáticos (imagens, ícones, CSS)
├── components/      # Componentes React reutilizáveis
│   ├── common/      # Componentes genéricos (Toast, ProtectedRoute)
│   ├── forms/       # Formulários (ClientForm, InvoiceForm, etc)
│   ├── layout/      # Layout principal (Header, Sidebar, MainLayout)
│   └── modals/      # Modais reutilizáveis
├── hooks/           # Custom React Hooks
├── pages/           # Páginas da aplicação
├── services/        # Serviços de API
├── stores/          # Stores Zustand (gestão de estado)
├── types/           # Definições de tipos TypeScript
└── utils/           # Funções utilitárias
```

## 🎨 Padrões de Desenvolvimento

### 1. Arquitetura de 4 Níveis para Páginas CRUD

Todas as páginas CRUD seguem a arquitetura de 4 níveis baseada na versão PHP:

```typescript
export default function ExamplePage() {
  return (
    <MainLayout>
      <div className="page-container">
        {/* Level 1: Page Title Section */}
        <div className="page-header">
          <h1 className="page-title">Título</h1>
          <p className="page-subtitle">Descrição</p>
        </div>

        {/* Level 2: Statistics Cards (opcional) */}
        <div className="stats-section">
          {/* Cards de estatísticas */}
        </div>

        {/* Level 3: Primary Actions */}
        <div className="page-actions">
          <button className="btn btn-primary">
            Adicionar
          </button>
        </div>

        {/* Level 4: Filters Section */}
        <div className="filters-section">
          {/* Filtros de pesquisa */}
        </div>

        {/* Level 5: Data Table */}
        <div className="table-section">
          {/* Tabela de dados */}
        </div>
      </div>
    </MainLayout>
  );
}
```

### 2. Hooks Personalizados

#### Padrão de Hooks de API

```typescript
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../services/api';

// Hook para buscar dados (GET)
export function useItems(filters?: FilterType) {
  return useQuery({
    queryKey: ['items', filters],
    queryFn: async () => {
      const response = await apiClient.get('/items', filters);
      return response;
    },
  });
}

// Hook para criar item (POST)
export function useCreateItem() {
  const queryClient = useQueryClient();
  
  return useMutation({
    mutationFn: async (data: CreateItemData) => {
      return await apiClient.post('/items', data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['items'] });
    },
  });
}

// Hook para atualizar item (PUT)
export function useUpdateItem() {
  const queryClient = useQueryClient();
  
  return useMutation({
    mutationFn: async ({ id, ...data }: UpdateItemData) => {
      return await apiClient.put(`/items/${id}`, data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['items'] });
    },
  });
}

// Hook para deletar item (DELETE)
export function useDeleteItem() {
  const queryClient = useQueryClient();
  
  return useMutation({
    mutationFn: async (id: number) => {
      return await apiClient.delete(`/items/${id}`);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['items'] });
    },
  });
}
```

### 3. Componentes de Formulário

Os formulários devem seguir este padrão:

```typescript
interface FormProps {
  mode: 'create' | 'edit';
  initialData?: ItemType;
  onSubmit: (data: FormData) => Promise<void>;
  onCancel: () => void;
  isSubmitting: boolean;
}

export default function ItemForm({ 
  mode, 
  initialData, 
  onSubmit, 
  onCancel, 
  isSubmitting 
}: FormProps) {
  const [formData, setFormData] = useState<FormData>(
    initialData || defaultValues
  );

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    await onSubmit(formData);
  };

  return (
    <form onSubmit={handleSubmit}>
      {/* Campos do formulário */}
      
      <div className="modal-actions">
        <button 
          type="button" 
          onClick={onCancel}
          disabled={isSubmitting}
        >
          Cancelar
        </button>
        <button 
          type="submit"
          disabled={isSubmitting}
        >
          {isSubmitting ? 'A guardar...' : 'Guardar'}
        </button>
      </div>
    </form>
  );
}
```

### 4. Gestão de Estado com Zustand

Para estado global, use Zustand:

```typescript
import { create } from 'zustand';
import { persist } from 'zustand/middleware';

interface StoreState {
  // Estado
  data: DataType | null;
  
  // Ações
  setData: (data: DataType) => void;
  clearData: () => void;
}

export const useStore = create<StoreState>()(
  persist(
    (set) => ({
      data: null,
      setData: (data) => set({ data }),
      clearData: () => set({ data: null }),
    }),
    {
      name: 'store-name',
    }
  )
);
```

### 5. Cards de Estatísticas

Para adicionar cards de estatísticas em uma página:

1. **Criar o hook de estatísticas** (em `src/hooks/`):

```typescript
export interface Statistics {
  totalItems: number;
  activeItems: number;
  // ... outros campos
}

export function useStatistics() {
  return useQuery<Statistics>({
    queryKey: ['statistics'],
    queryFn: async () => {
      const response = await apiClient.get<Statistics>('/endpoint/statistics');
      if ('totalItems' in response) {
        return response as unknown as Statistics;
      }
      return response.data as Statistics;
    },
    staleTime: 5 * 60 * 1000, // 5 minutos
  });
}
```

2. **Usar na página**:

```typescript
const { data: statistics, isLoading: isLoadingStats } = useStatistics();

// Renderizar cards
<div className="stats-section">
  <div className="stats-grid">
    <div className="stat-card stat-card-primary">
      <div className="stat-icon">
        <i className="fas fa-icon-name"></i>
      </div>
      <div className="stat-content">
        <h3 className="stat-title">Título</h3>
        <p className="stat-value">
          {isLoadingStats ? (
            <span className="spinner-small"></span>
          ) : (
            statistics?.totalItems || 0
          )}
        </p>
        <p className="stat-description">Descrição</p>
      </div>
    </div>
  </div>
</div>
```

## 🔐 Autenticação

O sistema usa JWT tokens para autenticação. O token é gerenciado pelo `apiClient` e armazenado no `localStorage`.

```typescript
// Login
const { login } = useAuthStore();
await login(credentials);

// Logout
const { logout } = useAuthStore();
logout();

// Verificar autenticação
const { isAuthenticated, user } = useAuthStore();
```

## 🎯 Boas Práticas

### TypeScript

1. **Sempre defina tipos explícitos** para props, state e funções
2. **Use interfaces para objetos** e `type` para unions/primitivos
3. **Evite `any`** - use `unknown` se necessário
4. **Exporte tipos** que serão reutilizados

### React

1. **Componentes pequenos e focados** - uma responsabilidade por componente
2. **Use hooks personalizados** para lógica reutilizável
3. **Memoize componentes pesados** com `React.memo()`
4. **Use `useCallback` e `useMemo`** quando apropriado

### Nomenclatura

- **Componentes**: PascalCase (`ClientForm`, `UserCard`)
- **Hooks**: camelCase com prefixo `use` (`useClients`, `useAuth`)
- **Funções**: camelCase (`handleSubmit`, `fetchData`)
- **Constantes**: UPPER_SNAKE_CASE (`API_BASE_URL`)
- **Tipos/Interfaces**: PascalCase (`Client`, `UserStatistics`)

### Git Commits

Siga o padrão de commits semânticos:

```
feat: adiciona novo recurso
fix: corrige bug
docs: atualiza documentação
style: formatação de código
refactor: refatoração sem mudança de funcionalidade
test: adiciona ou corrige testes
chore: tarefas de manutenção
```

## 🔌 Integração com API

### Configuração

O endpoint da API é configurado em `.env`:

```env
VITE_API_BASE_URL=http://localhost:8080
```

### Documentação da API

A documentação completa da API está disponível em:
- Swagger UI: `http://localhost:8080/v3/api-docs`

### Endpoints Comuns

```typescript
// Usuários
GET    /users/statistics         // Estatísticas de usuários
GET    /users/paginated          // Lista paginada
GET    /users/{id}               // Usuário específico
POST   /users                    // Criar usuário
PUT    /users/{id}               // Atualizar usuário
DELETE /users/{id}               // Deletar usuário

// Autenticação
POST   /auth/login               // Login
POST   /auth/register            // Registro
POST   /auth/logout              // Logout
GET    /auth/profile             // Perfil do usuário logado

// Contas (Admins)
GET    /admins                   // Lista de administradores
GET    /admins/{id}              // Admin específico
GET    /admins/statistics        // Estatísticas de admins
GET    /admins/paginated         // Lista paginada com filtros
POST   /admins                   // Criar admin
POST   /admin/upload-image       // Upload imagem do admin
PUT    /admins/{id}              // Atualizar admin
DELETE /admins/{id}              // Deletar admin

// Admins - Detalhes dos Endpoints (Swagger)
/**
 * GET /admins/statistics
 * Resposta: AdminStatisticsResponse
 * {
 *   totalAdmins: number        // Total de administradores
 *   activeAdmins: number       // Administradores ativos
 *   inactiveAdmins: number     // Administradores inativos
 *   eliminatedAdmins: number   // Administradores eliminados
 * }
 */

/**
 * GET /admins/paginated
 * Parâmetros de Query:
 * - search: string (padrão: "")
 * - page: number (padrão: 0)
 * - size: number (padrão: 10)
 * - sortBy: string (padrão: "id")
 * - sortDirection: "ASC" | "DESC" (padrão: "ASC")
 * - stateId?: number (opcional)
 * 
 * Resposta: PaginatedResponseAdminResponse
 * {
 *   content: AdminResponse[]
 *   pageNumber: number
 *   pageSize: number
 *   totalElements: number
 *   totalPages: number
 *   first: boolean
 *   last: boolean
 *   hasNext: boolean
 *   hasPrevious: boolean
 * }
 */

/**
 * AdminResponse (Schema)
 * {
 *   id: number
 *   email: string
 *   name: string
 *   img?: string
 *   authId?: number
 *   username?: string
 *   stateId?: number
 *   state?: string
 *   createdAt?: string (date-time)
 *   updatedAt?: string (date-time)
 * }
 */

/**
 * AdminDto (Create/Update)
 * {
 *   email: string (required)
 *   name: string (required)
 *   img?: string
 *   password?: string
 *   contact?: string
 *   accountTypeId: number (required)
 *   stateId: number (required)
 * }
 */
```

## 🧪 Testes

```bash
# Rodar testes
npm run test

# Testes com coverage
npm run test:coverage

# Testes em modo watch
npm run test:watch
```

## 📦 Build e Deploy

```bash
# Desenvolvimento
npm run dev

# Build para produção
npm run build

# Preview da build
npm run preview

# Lint
npm run lint

# Format
npm run format
```

## 🐛 Debug

### React Query Devtools

O projeto inclui React Query Devtools para debug de queries:

```typescript
import { ReactQueryDevtools } from '@tanstack/react-query-devtools';

// Aparece automaticamente em modo dev
```

### Console Logging

Em desenvolvimento, todas as chamadas de API são logadas no console:

```
[API] GET /users/statistics
[API] Response: {...}
```

## 📚 Recursos Úteis

- [React Documentation](https://react.dev/)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [TanStack Query](https://tanstack.com/query/latest)
- [Zustand](https://github.com/pmndrs/zustand)
- [Vite](https://vitejs.dev/)

## 🆘 Problemas Comuns

### Erro de CORS

Se houver problemas de CORS, configure o proxy no `vite.config.ts`:

```typescript
export default defineConfig({
  server: {
    proxy: {
      '/api': {
        target: 'http://localhost:8080',
        changeOrigin: true,
      }
    }
  }
})
```

### Token Expirado

Se o token expirar, o `apiClient` automaticamente faz logout e redireciona para `/login`.

### Cache de Queries

Para invalidar cache manualmente:

```typescript
const queryClient = useQueryClient();
queryClient.invalidateQueries({ queryKey: ['items'] });
```

## 📝 Checklist para Novas Features

- [ ] Criar tipos em `src/types/`
- [ ] Criar hooks em `src/hooks/`
- [ ] Criar componentes em `src/components/`
- [ ] Criar página em `src/pages/`
- [ ] Adicionar rota no `App.tsx`
- [ ] Adicionar item no `Sidebar.tsx`
- [ ] Testar funcionalidade
- [ ] Atualizar documentação se necessário

---

**Última atualização**: Outubro 2025
**Versão**: 2.0.0
**Maintainer**: Equipe Automo
