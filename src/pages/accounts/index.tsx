import { UserCheck, UserMinus, Users, UserX } from "lucide-react";
import { useState } from "react";
import { type ColumnDef, DataTable } from "@/components/common/data-table";
import {
	type FilterField,
	TableFilters,
} from "@/components/common/table-filters";
import { Button } from "@/components/ui/button";
import { DashboardCard } from "@/components/ui/dashboard-card";
import { useAdminStatistics, useAdmins } from "@/hooks/useAdmins";
import type { Admin, AdminFilters } from "@/types/admin";

// Local components
import CreateModal from "./components/create-modal";
import DeleteModal from "./components/delete-modal";
import EditModal from "./components/edit-modal";
import { AccountActions } from "./components/table-actions";
import { AdminCell, StateBadgeCell } from "./components/table-cells";
import ViewModal from "./components/view-modal";

export default function AccountsPage() {
	const [filters, setFilters] = useState<AdminFilters>({
		search: "",
		stateId: undefined,
	});
	const [page, setPage] = useState(0);
	const [pageSize] = useState(10);

	const queryFilters = {
		search: filters.search || undefined,
		page: page,
		size: pageSize,
		sortBy: "id" as const,
		sortDirection: "ASC" as const,
	};
	const { data: adminsData, isLoading, isError } = useAdmins(queryFilters);
	const admins = adminsData?.content || [];
	const { data: statistics } = useAdminStatistics();

	const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
	const [isViewModalOpen, setIsViewModalOpen] = useState(false);
	const [isEditModalOpen, setIsEditModalOpen] = useState(false);
	const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
	const [selectedAdmin, setSelectedAdmin] = useState<Admin | null>(null);

	const handleFilterChange = (name: string, value: string | undefined) => {
		setFilters((prev) => ({ ...prev, [name]: value }));
		setPage(0); // Reset to first page on filter change
	};

	const handleClearFilters = () => {
		setFilters({
			search: "",
			stateId: undefined,
		});
		setPage(0);
	};

	// Define filter fields
	const filterFields: FilterField[] = [
		{
			name: "search",
			label: "Pesquisar",
			type: "text",
			placeholder: "Nome, email, username...",
			icon: "fas fa-search",
		},
	];

	const handleCreateAdmin = () => {
		setSelectedAdmin(null);
		setIsCreateModalOpen(true);
	};

	const handleViewAdmin = (admin: Admin) => {
		setSelectedAdmin(admin);
		setIsViewModalOpen(true);
	};

	const handleEditAdmin = (admin: Admin) => {
		setSelectedAdmin(admin);
		setIsEditModalOpen(true);
	};

	const handleDeleteAdmin = (admin: Admin) => {
		setSelectedAdmin(admin);
		setIsDeleteModalOpen(true);
	};

	// Define columns for DataTable
	const columns: ColumnDef<Admin>[] = [
		{
			id: "admin",
			header: "Administrador",
			cell: ({ row }) => <AdminCell admin={row.original} />,
		},
		{
			accessorKey: "username",
			header: "Username",
			cell: ({ row }) => `@${row.original.username || "N/A"}`,
		},
		{
			id: "state",
			header: "Estado",
			cell: ({ row }) => <StateBadgeCell state={row.original.state || "N/A"} />,
		},
		{
			id: "actions",
			header: "Ações",
			cell: ({ row }) => (
				<AccountActions
					admin={row.original}
					onView={handleViewAdmin}
					onEdit={handleEditAdmin}
					onDelete={handleDeleteAdmin}
				/>
			),
		},
	];

	return (
		<>
			<div className="space-y-5 xl:space-y-8">
				{/* Page Header */}
				<section className="flex justify-between">
					<article className="px-2 sm:px-0">
						<h1 className="text-2xl font-bold tracking-tight sm:text-3xl">
							Contas e Permissões
						</h1>
						<p className="text-muted-foreground text-sm sm:text-base">
							Gestão de contas de utilizadores e permissões
						</p>
					</article>

					{/* Primary Action Button */}
					<Button size="lg" onClick={handleCreateAdmin}>
						<i className="fas fa-plus"></i>
						<span>Novo Admin</span>
					</Button>
				</section>

				{/* Stats Cards */}
				<div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
					<DashboardCard
						stat={{
							title: "Total Administradores",
							value: String(statistics?.totalAdmins || 0),
							change: "+0%",
							changeType: "positive",
							icon: Users,
							color: "text-blue-500",
							bgColor: "bg-blue-500/10",
						}}
						index={0}
						noProgressBar
						noTrending
					/>
					<DashboardCard
						stat={{
							title: "Ativos",
							value: String(statistics?.activeAdmins || 0),
							change: "+0%",
							changeType: "positive",
							icon: UserCheck,
							color: "text-green-500",
							bgColor: "bg-green-500/10",
						}}
						index={1}
						noProgressBar
						noTrending
					/>
					<DashboardCard
						stat={{
							title: "Inativos",
							value: String(statistics?.inactiveAdmins || 0),
							change: "0%",
							changeType: "negative",
							icon: UserX,
							color: "text-gray-500",
							bgColor: "bg-gray-500/10",
						}}
						index={2}
						noProgressBar
						noTrending
					/>
					<DashboardCard
						stat={{
							title: "Eliminados",
							value: String(statistics?.eliminatedAdmins || 0),
							change: "0%",
							changeType: "negative",
							icon: UserMinus,
							color: "text-red-500",
							bgColor: "bg-red-500/10",
						}}
						index={3}
						noProgressBar
						noTrending
					/>
				</div>

				{/* Filters Section */}
				<TableFilters
					fields={filterFields}
					values={filters}
					onChange={handleFilterChange}
					onClear={handleClearFilters}
				/>

				{/* Data Table Section */}
				<DataTable
					data={admins}
					columns={columns}
					isLoading={isLoading}
					isError={isError}
					errorMessage="Erro ao carregar contas. Tente novamente."
					emptyMessage="Nenhum administrador encontrado"
					pagination={{
						page,
						pageSize,
						totalElements: adminsData?.totalElements || 0,
						totalPages: adminsData?.totalPages || 1,
						hasNext: adminsData?.hasNext || false,
						hasPrevious: adminsData?.hasPrevious || false,
						onPageChange: setPage,
					}}
				/>
			</div>

			{/* Modals */}
			<CreateModal
				open={isCreateModalOpen}
				onOpenChange={setIsCreateModalOpen}
			/>

			<ViewModal
				open={isViewModalOpen}
				onOpenChange={setIsViewModalOpen}
				admin={selectedAdmin}
			/>

			<EditModal
				open={isEditModalOpen}
				onOpenChange={setIsEditModalOpen}
				admin={selectedAdmin}
			/>

			<DeleteModal
				open={isDeleteModalOpen}
				onOpenChange={setIsDeleteModalOpen}
				admin={selectedAdmin}
			/>
		</>
	);
}
