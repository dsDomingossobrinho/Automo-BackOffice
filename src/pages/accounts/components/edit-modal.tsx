import { toast } from "sonner";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { useUpdateAdmin } from "@/hooks/useAdmins";
import type { CreateAccountData } from "@/types";
import type { Admin } from "@/types/admin";
import AccountForm from "./form";

interface EditModalProps {
	open: boolean;
	onOpenChange: (open: boolean) => void;
	admin: Admin | null;
}

export default function EditModal({
	open,
	onOpenChange,
	admin,
}: EditModalProps) {
	const updateMutation = useUpdateAdmin();

	const handleSubmit = async (data: CreateAccountData) => {
		if (!admin) return;

		try {
			await updateMutation.mutateAsync({
				id: admin.id,
				...data,
			});
			toast.success("Administrador atualizado com sucesso!");
			onOpenChange(false);
		} catch (error: unknown) {
			const message =
				error instanceof Error
					? error.message
					: "Erro ao atualizar administrador";
			toast.error(message);
		}
	};

	if (!admin) return null;

	// Convert Admin to Account format for the form
	const accountData = {
		id: admin.id,
		email: admin.email,
		username: admin.username || "",
		name: admin.name,
		contact: "",
		identify_id: "",
		roleId: 2,
		permissions: [],
		accountTypeId: admin.authId,
		isBackOffice: true,
	};

	return (
		<ResponsiveDialog
			open={open}
			onOpenChange={updateMutation.isPending ? () => {} : onOpenChange}
			title="Editar Administrador"
			description="Atualize as informações da conta."
		>
			<AccountForm
				account={accountData}
				onSubmit={handleSubmit}
				isLoading={updateMutation.isPending}
			/>
		</ResponsiveDialog>
	);
}
