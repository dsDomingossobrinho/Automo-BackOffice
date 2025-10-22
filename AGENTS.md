# Automo BackOffice - Instruções de Desenvolvimento

## 📋 Visão Geral do Projeto

Este é o BackOffice do sistema Automo, desenvolvido em **React + TypeScript com Vite**. O projeto segue uma arquitetura moderna baseada em componentes reutilizáveis, hooks personalizados com React Query, e UI components do shadcn/ui.

## 🏗️ Arquitetura do Projeto

### Estrutura de Pastas

```
src/
├── assets/          # Recursos estáticos (imagens, ícones, CSS)
├── components/      # Componentes React GLOBAIS reutilizáveis
│   ├── common/      # Componentes genéricos (DataTable, ResponsiveDialog, TableFilters)
│   ├── layout/      # Layout principal (Header, Sidebar, MainLayout)
│   └── ui/          # Componentes UI do shadcn/ui
├── hooks/           # Custom React Hooks (useAdmins, useClients, etc)
├── lib/             # Utilitários e configurações
├── pages/           # Páginas da aplicação (cada página tem sua própria estrutura)
│   ├── {entity}/    # Pasta da entidade (ex: accounts, clients, finances)
│   │   ├── index.tsx           # Página principal com lógica e estado
│   │   └── components/         # Componentes específicos APENAS desta página
│   │       ├── create-modal.tsx      # Modal de criação
│   │       ├── edit-modal.tsx        # Modal de edição
│   │       ├── view-modal.tsx        # Modal de visualização
│   │       ├── delete-modal.tsx      # Modal de exclusão
│   │       ├── form.tsx              # Formulário (usado por create/edit)
│   │       ├── table-actions.tsx     # Ações da tabela (opcional)
│   │       └── table-cells.tsx       # Células customizadas (opcional)
│   │
│   ├── dashboard/   # Páginas simples sem modais
│   │   └── index.tsx
│   │
│   └── auth/        # Páginas de autenticação
│       ├── login.tsx
│       └── register.tsx
│
├── services/        # Serviços de API (apiClient)
├── stores/          # Stores Zustand (gestão de estado)
├── types/           # Definições de tipos TypeScript
└── utils/           # Funções utilitárias
```

### 📁 Organização de Páginas com Modais e Formulários

**Novo Padrão**: Cada página que contém modais e formulários deve ter sua própria pasta com componentes específicos.

#### Estrutura de uma Página

```
src/pages/{entity}/
├── index.tsx                    # Página principal com lógica de estado e DataTable
└── components/                  # Componentes específicos APENAS desta página
    ├── create-modal.tsx         # Modal de criação
    ├── edit-modal.tsx           # Modal de edição
    ├── view-modal.tsx           # Modal de visualização
    ├── delete-modal.tsx         # Modal de exclusão
    ├── form.tsx                 # Formulário reutilizado pelos modais
    ├── table-actions.tsx        # Actions da tabela (se complexo)
    └── table-cells.tsx          # Células customizadas da tabela (se complexo)
```

#### Exemplo Real: Página de Contas

```
src/pages/accounts/
├── index.tsx                    # Gestão de contas
└── components/
    ├── create-modal.tsx
    ├── edit-modal.tsx
    ├── view-modal.tsx
    ├── delete-modal.tsx
    ├── form.tsx
    ├── table-actions.tsx        # Botões de ação (View, Edit, Delete)
    └── table-cells.tsx          # Células customizadas (Avatar + Nome, Status Badge)
```

#### Exemplo: Página de Finanças (Transações)

```
src/pages/finances/
├── index.tsx                    # Gestão de transações financeiras
└── components/
    ├── create-modal.tsx         # Modal para criar transação
    ├── edit-modal.tsx           # Modal para editar transação
    ├── view-modal.tsx           # Modal para visualizar detalhes
    ├── delete-modal.tsx         # Modal para confirmar exclusão
    ├── form.tsx                 # Formulário de transação
    ├── table-actions.tsx        # Actions específicas de transações
    └── table-cells.tsx          # Células: tipo, valor, status, etc.
```

#### Regras de Organização

1. **Componentes Globais** (`src/components/`):

   - Apenas componentes **verdadeiramente reutilizáveis** em múltiplas páginas
   - Exemplos: `DataTable`, `ResponsiveDialog`, `TableFilters`, `DashboardCard`
   - Layout da aplicação: `Header`, `Sidebar`, `MainLayout`
   - UI primitivos do shadcn/ui

2. **Componentes Específicos de Página** (`src/pages/{entity}/components/`):

   - **Modais CRUD**: `create-modal.tsx`, `edit-modal.tsx`, `view-modal.tsx`, `delete-modal.tsx`
   - **Formulários**: `form.tsx` (reutilizado pelos modais de create e edit)
   - **Table Actions**: `table-actions.tsx` (quando há muitas ações ou lógica complexa)
   - **Table Cells**: `table-cells.tsx` (células customizadas complexas, ex: Avatar+Nome, Status+Badge)
   - **Não devem** ser importados por outras páginas

3. **Nomenclatura de Arquivos**:

   - Sempre em **kebab-case**: `create-modal.tsx`, `form.tsx`, `table-actions.tsx`
   - **Modais**: `create-modal.tsx`, `edit-modal.tsx`, `view-modal.tsx`, `delete-modal.tsx`
   - **Formulários**: `form.tsx`
   - **Table Components**: `table-actions.tsx`, `table-cells.tsx`
   - ❌ **NÃO use**: `create-account-modal.tsx`, `AccountForm.tsx`
   - ✅ **USE**: `create-modal.tsx`, `form.tsx`

4. **Quando separar Table Actions e Cells**:

   - **Separar `table-actions.tsx`** quando:

     - Há mais de 3 botões de ação por linha
     - Lógica complexa de permissões/condicionais
     - Actions com dropdowns ou menus

   - **Separar `table-cells.tsx`** quando:
     - Células com componentes complexos (Avatar+Info, Badges múltiplos)
     - Células com lógica de formatação complexa (datas, moedas, status)
     - Células reutilizadas em múltiplas colunas da mesma tabela

5. **Imports**:
   - Componentes globais: `import { DataTable } from '@/components/common/data-table'`
   - Componentes locais: `import CreateModal from './components/create-modal'`
   - Table components: `import { AccountActions } from './components/table-actions'`
   - Hooks: `import { useAccounts } from '@/hooks/useAccounts'`
   - Types: `import type { Account } from '@/types'`

## 🎨 Padrões de Desenvolvimento

### 1. Estrutura de Páginas

Todas as páginas seguem esta estrutura consistente:

```tsx
export default function ExamplePage() {
  const [filters, setFilters] = useState<FilterType>({});
  const [page, setPage] = useState(0);
  const [pageSize] = useState(10);

  // React Query hooks
  const { data, isLoading, isError } = useItems(filters, page, pageSize);
  const { data: statistics } = useItemStatistics();

  return (
    <div className="space-y-5 xl:space-y-8">
      {/* 1. Page Header */}
      <section className="flex justify-between">
        <article className="px-2 sm:px-0">
          <h1 className="text-2xl font-bold tracking-tight sm:text-3xl">
            Título da Página
          </h1>
          <p className="text-muted-foreground text-sm sm:text-base">
            Descrição da página
          </p>
        </article>

        {/* Primary Action Button */}
        <Button size="lg" onClick={handleCreate}>
          <i className="fas fa-plus"></i>
          <span>Novo Item</span>
        </Button>
      </section>

      {/* 2. Statistics Cards (opcional) */}
      <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <DashboardCard
          stat={{
            title: "Total",
            value: String(statistics?.total || 0),
            change: "+0%",
            changeType: "positive",
            icon: IconComponent,
            color: "text-blue-500",
            bgColor: "bg-blue-500/10",
          }}
          index={0}
          noProgressBar
          noTrending
        />
      </div>

      {/* 3. Filters Section */}
      <TableFilters
        fields={filterFields}
        values={filters}
        onChange={handleFilterChange}
        onClear={handleClearFilters}
      />

      {/* 4. Data Table */}
      <DataTable
        data={items}
        columns={columns}
        isLoading={isLoading}
        isError={isError}
        errorMessage="Erro ao carregar dados"
        emptyMessage="Nenhum item encontrado"
        pagination={{
          page,
          pageSize,
          totalElements: data?.totalElements || 0,
          totalPages: data?.totalPages || 1,
          hasNext: data?.hasNext || false,
          hasPrevious: data?.hasPrevious || false,
          onPageChange: setPage,
        }}
      />
    </div>
  );
}
```

### 2. Hooks Personalizados com React Query

#### Padrão de Hooks de API

```typescript
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { apiClient } from "@/services/api";

// Hook para buscar dados (GET)
export function useItems(filters?: FilterType, page = 0, size = 10) {
  return useQuery({
    queryKey: ["items", filters, page, size],
    queryFn: async () => {
      const response = await apiClient.get<PaginatedResponse<Item>>(
        "/items/paginated",
        {
          ...filters,
          page,
          size,
        }
      );
      return response;
    },
    staleTime: 5 * 60 * 1000, // 5 minutos
  });
}

// Hook para estatísticas (GET)
export function useItemStatistics() {
  return useQuery({
    queryKey: ["item-statistics"],
    queryFn: async () => {
      const response = await apiClient.get<Statistics>("/items/statistics");
      return response;
    },
    staleTime: 5 * 60 * 1000,
  });
}

// Hook para criar item (POST)
export function useCreateItem() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (data: CreateItemData) => {
      return await apiClient.post("/items", data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["items"] });
      queryClient.invalidateQueries({ queryKey: ["item-statistics"] });
    },
  });
}

// Hook para atualizar item (PUT)
export function useUpdateItem() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ id, ...data }: UpdateItemData & { id: number }) => {
      return await apiClient.put(`/items/${id}`, data);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["items"] });
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
      queryClient.invalidateQueries({ queryKey: ["items"] });
      queryClient.invalidateQueries({ queryKey: ["item-statistics"] });
    },
  });
}
```

### 3. DataTable Component

O `DataTable` é o componente padrão para tabelas:

```tsx
import { type ColumnDef, DataTable } from "@/components/common/data-table";

// Definir colunas
const columns: ColumnDef<Item>[] = [
  {
    id: "name",
    header: "Nome",
    cell: ({ row }) => (
      <div className="flex items-center gap-3">
        <Avatar>
          <AvatarImage src={row.original.img} alt={row.original.name} />
          <AvatarFallback>
            {row.original.name.substring(0, 2).toUpperCase()}
          </AvatarFallback>
        </Avatar>
        <div>
          <div className="font-medium">{row.original.name}</div>
          <span className="text-muted-foreground text-xs">
            {row.original.email}
          </span>
        </div>
      </div>
    ),
  },
  {
    accessorKey: "status",
    header: "Status",
    cell: ({ row }) => <StatusBadge status={row.original.status} />,
  },
  {
    id: "actions",
    header: "Ações",
    cell: ({ row }) => (
      <div className="flex items-center justify-center gap-1">
        <Button
          variant="ghost"
          size="icon"
          onClick={() => onView(row.original)}
        >
          <i className="fas fa-eye"></i>
        </Button>
        <Button
          variant="ghost"
          size="icon"
          onClick={() => onEdit(row.original)}
        >
          <i className="fas fa-edit"></i>
        </Button>
        <Button
          variant="ghost"
          size="icon"
          onClick={() => onDelete(row.original)}
        >
          <i className="fas fa-trash"></i>
        </Button>
      </div>
    ),
  },
];

// Usar na página
<DataTable
  data={items}
  columns={columns}
  isLoading={isLoading}
  isError={isError}
  errorMessage="Erro ao carregar dados"
  emptyMessage="Nenhum item encontrado"
  pagination={{
    page,
    pageSize,
    totalElements: data?.totalElements || 0,
    totalPages: data?.totalPages || 1,
    hasNext: data?.hasNext || false,
    hasPrevious: data?.hasPrevious || false,
    onPageChange: setPage,
  }}
/>;
```

### 4. ResponsiveDialog Component

Para modais, use o `ResponsiveDialog`:

```tsx
import { ResponsiveDialog } from '@/components/common/responsive-dialog';

// Modal simples
<ResponsiveDialog
  open={isOpen}
  onOpenChange={setIsOpen}
  title="Título do Modal"
  description="Descrição opcional"
>
  <div className="space-y-4">
    {/* Conteúdo do modal */}
  </div>
</ResponsiveDialog>

// Modal com ações customizadas
<ResponsiveDialog
  open={isOpen}
  onOpenChange={setIsOpen}
  title="Eliminar Item"
  description="Esta ação não pode ser revertida!"
  actions={[
    {
      label: "Cancelar",
      variant: "outline",
      onClick: () => setIsOpen(false),
      disabled: isLoading,
    },
    {
      label: "Eliminar",
      variant: "destructive",
      onClick: handleDelete,
      disabled: isLoading,
      loading: isLoading,
      icon: Trash2,
    },
  ]}
>
  <div className="flex flex-col items-center gap-4 py-4">
    {/* Conteúdo de confirmação */}
  </div>
</ResponsiveDialog>
```

### 5. Formulários

Os formulários seguem este padrão:

```tsx
interface FormProps {
  account?: Account;
  onSubmit: (data: CreateAccountData) => Promise<void>;
  isLoading?: boolean;
}

export default function ItemForm({
  account,
  onSubmit,
  isLoading = false,
}: FormProps) {
  const [formData, setFormData] = useState<FormData>(account || defaultValues);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    await onSubmit(formData);
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      {/* Campos do formulário usando shadcn/ui */}
      <div className="space-y-2">
        <Label htmlFor="name">Nome</Label>
        <Input
          id="name"
          value={formData.name}
          onChange={(e) => setFormData({ ...formData, name: e.target.value })}
          required
        />
      </div>

      {/* Botões de ação */}
      <div className="flex justify-end gap-2 pt-4">
        <Button type="submit" disabled={isLoading}>
          {isLoading ? (
            <>
              <i className="fas fa-spinner fa-spin"></i>
              <span>A guardar...</span>
            </>
          ) : (
            "Guardar"
          )}
        </Button>
      </div>
    </form>
  );
}
```

### 6. Toast Notifications

Use o toast do Sonner:

```tsx
import { toast } from "sonner";

// Sucesso
toast.success("Operação realizada com sucesso!");

// Erro
toast.error("Erro ao realizar operação");

// Info
toast.info("Informação importante");

// Warning
toast.warning("Atenção!");

// Promise
toast.promise(apiCall(), {
  loading: "A processar...",
  success: "Sucesso!",
  error: "Erro ao processar",
});
```

### 7. Ícones

Use **Lucide React** para ícones:

```tsx
import {
  Users,
  UserCheck,
  UserX,
  Trash2,
  Edit,
  Eye,
  Plus,
  AlertTriangle
} from 'lucide-react';

// Uso em componentes
<Button>
  <Plus className="h-4 w-4" />
  <span>Adicionar</span>
</Button>

// Em DashboardCard
<DashboardCard
  stat={{
    icon: Users, // Componente do Lucide
    color: "text-blue-500",
    // ...
  }}
/>
```

### 8. Gestão de Estado com Zustand

Para estado global, use Zustand:

```typescript
import { create } from "zustand";
import { persist } from "zustand/middleware";

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
      name: "store-name",
    }
  )
);
```

## 🔐 Autenticação

O sistema usa JWT tokens para autenticação:

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
5. **Use tipos genéricos** quando apropriado

### React

1. **Componentes pequenos e focados** - uma responsabilidade por componente
2. **Use React Query** para todas as chamadas de API
3. **Memoize componentes pesados** com `React.memo()`
4. **Use `useCallback` e `useMemo`** quando apropriado
5. **Siga o padrão de composição** do shadcn/ui

### CSS e Estilos

1. **Sempre use Lucide Icons** para ícones
2. **Use classes utilitárias** do Tailwind
3. **Siga o design system** do shadcn/ui
4. **Use variantes responsivas** (`sm:`, `md:`, `lg:`, `xl:`)
5. **Prefira classes do Tailwind** a CSS customizado
6. **Use `cn()` utility** para merge de classes condicionais

### Nomenclatura

- **Componentes**: PascalCase (`AccountForm`, `DashboardCard`)
- **Hooks**: camelCase com prefixo `use` (`useAdmins`, `useAuth`)
- **Funções**: camelCase (`handleSubmit`, `fetchData`)
- **Constantes**: UPPER_SNAKE_CASE (`API_BASE_URL`)
- **Tipos/Interfaces**: PascalCase (`Admin`, `AdminStatistics`)
- **Arquivos**: kebab-case (`admin-form.tsx`)
- **Páginas**: nome da pasta em kebab-case com arquivo `index.tsx` dentro (`src/pages/admin-users/index.tsx`)

### Tailwind CSS

1. **Use classes utilitárias** do Tailwind
2. **Siga o design system** do shadcn/ui
3. **Use variantes responsivas** (`sm:`, `md:`, `lg:`, `xl:`)
4. **Prefira classes do Tailwind** a CSS customizado
5. **Use `cn()` utility** para merge de classes condicionais

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

A documentação completa da API (Swagger) está disponível em:

- **Swagger UI**: `http://localhost:8080/v3/api-docs`

### API Client

Use o `apiClient` para todas as chamadas:

```typescript
import { apiClient } from "@/services/api";

// GET
const data = await apiClient.get<ResponseType>("/endpoint");

// GET com parâmetros
const data = await apiClient.get<ResponseType>("/endpoint", {
  param1: "value1",
  param2: "value2",
});

// POST
const result = await apiClient.post("/endpoint", payload);

// PUT
const result = await apiClient.put(`/endpoint/${id}`, payload);

// DELETE
await apiClient.delete(`/endpoint/${id}`);
```

### Endpoints Comuns

Consulte o Swagger em `http://localhost:8080/v3/api-docs` para a documentação completa.

Principais endpoints:

```typescript
// Administradores
GET / admins / statistics; // Estatísticas
GET / admins / paginated; // Lista paginada
GET / admins / { id }; // Admin específico
POST / admins; // Criar admin
PUT / admins / { id }; // Atualizar admin
DELETE / admins / { id }; // Deletar admin

// Usuários (Clientes)
GET / users / statistics; // Estatísticas
GET / users / paginated; // Lista paginada
GET / users / { id }; // Usuário específico
POST / users; // Criar usuário
PUT / users / { id }; // Atualizar usuário
DELETE / users / { id }; // Deletar usuário

// Autenticação
POST / auth / login; // Login
POST / auth / register; // Registro
POST / auth / logout; // Logout
GET / auth / profile; // Perfil do usuário logado
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
import { ReactQueryDevtools } from "@tanstack/react-query-devtools";

// Aparece automaticamente em modo dev
```

### Console Logging

Em desenvolvimento, todas as chamadas de API são logadas no console.

## 📚 Recursos Úteis

- [React Documentation](https://react.dev/)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [TanStack Query](https://tanstack.com/query/latest)
- [shadcn/ui](https://ui.shadcn.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Lucide Icons](https://lucide.dev/)
- [Zustand](https://github.com/pmndrs/zustand)
- [Vite](https://vitejs.dev/)

## 🆘 Problemas Comuns

### Erro de CORS

Se houver problemas de CORS, configure o proxy no `vite.config.ts`:

```typescript
export default defineConfig({
  server: {
    proxy: {
      "/api": {
        target: "http://localhost:8080",
        changeOrigin: true,
      },
    },
  },
});
```

### Token Expirado

Se o token expirar, o `apiClient` automaticamente faz logout e redireciona para `/login`.

### Cache de Queries

Para invalidar cache manualmente:

```typescript
const queryClient = useQueryClient();
queryClient.invalidateQueries({ queryKey: ["items"] });
```

## 📝 Checklist para Novas Features

- [ ] Criar tipos em `src/types/`
- [ ] Criar hooks com React Query em `src/hooks/`
- [ ] Criar componentes em `src/components/`
- [ ] Usar `DataTable` para tabelas
- [ ] Usar `ResponsiveDialog` para modais
- [ ] Usar ícones do Lucide
- [ ] Usar Tailwind CSS + shadcn/ui
- [ ] Criar página em `src/pages/`
- [ ] Adicionar rota no `routes.tsx`
- [ ] Adicionar item no `Sidebar.tsx`
- [ ] Testar funcionalidade
- [ ] Atualizar documentação se necessário

## 🎨 Componentes UI Disponíveis (shadcn/ui)

- `Button` - Botões com variantes
- `Input` - Campos de texto
- `Label` - Labels para formulários
- `Select` - Dropdown select
- `Checkbox` - Caixas de seleção
- `Avatar` - Avatares de usuário
- `Badge` - Badges de status
- `Card` - Cards container
- `Dialog` - Modais (use `ResponsiveDialog` ao invés)
- `DropdownMenu` - Menus dropdown
- `Separator` - Separadores visuais
- `Skeleton` - Loading skeletons
- `Table` - Tabelas (use `DataTable` ao invés)
- E muitos outros em `src/components/ui/`

---

**Última atualização**: Janeiro 2025  
**Versão**: 3.0.0 (React + TypeScript)  
**Maintainer**: Equipe Automo
