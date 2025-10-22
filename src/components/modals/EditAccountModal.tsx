import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { useUpdateAccount } from "@/hooks/useAccounts";
import type { Account, CreateAccountData } from "@/types";
import AccountForm from "../forms/AccountForm";

interface EditAccountModalProps {
	isOpen: boolean;
	onClose: () => void;
	account: Account | null;
	onSuccess?: (message: string) => void;
	onError?: (message: string) => void;
}

/**
 * Edit Account Modal
 * Modal para editar conta existente usando ResponsiveDialog
 */
export default function EditAccountModal({
	isOpen,
	onClose,
	account,
	onSuccess,
	onError,
}: Readonly<EditAccountModalProps>) {
	const updateMutation = useUpdateAccount();

	const handleSubmit = async (data: CreateAccountData) => {
		if (!account) return;

		try {
			await updateMutation.mutateAsync({
				id: account.id,
				...data,
			});
			onSuccess?.("Conta atualizada com sucesso!");
			onClose();
		} catch (error: unknown) {
			const message =
				error instanceof Error ? error.message : "Erro ao atualizar conta";
			onError?.(message);
		}
	};

	if (!account) return null;

	return (
		<ResponsiveDialog
			open={isOpen}
			onOpenChange={(open) => {
				if (!open && !updateMutation.isPending) {
					onClose();
				}
			}}
			title="Editar Conta"
			description="Atualize as informações da conta"
		>
			<AccountForm
				account={account}
				onSubmit={handleSubmit}
				isLoading={updateMutation.isPending}
			/>
		</ResponsiveDialog>
	);
}
