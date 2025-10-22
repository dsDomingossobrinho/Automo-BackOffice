import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { useUpdateInvoice } from "@/hooks/useInvoices";
import type { CreateInvoiceData, Invoice } from "@/types";
import InvoiceForm from "../forms/InvoiceForm";

interface EditInvoiceModalProps {
	isOpen: boolean;
	onClose: () => void;
	invoice: Invoice | null;
	onSuccess?: (message: string) => void;
	onError?: (message: string) => void;
}

/**
 * Edit Invoice Modal
 * Modal para editar fatura existente usando ResponsiveDialog
 */
export default function EditInvoiceModal({
	isOpen,
	onClose,
	invoice,
	onSuccess,
	onError,
}: Readonly<EditInvoiceModalProps>) {
	const updateMutation = useUpdateInvoice();

	const handleSubmit = async (data: CreateInvoiceData) => {
		if (!invoice) return;

		try {
			await updateMutation.mutateAsync({
				id: invoice.id,
				...data,
			});
			onSuccess?.("Fatura atualizada com sucesso!");
			onClose();
		} catch (error: unknown) {
			const message =
				error instanceof Error ? error.message : "Erro ao atualizar fatura";
			onError?.(message);
		}
	};

	if (!invoice) return null;

	return (
		<ResponsiveDialog
			open={isOpen}
			onOpenChange={(open) => {
				if (!open && !updateMutation.isPending) {
					onClose();
				}
			}}
			title="Editar Fatura"
			description="Atualize as informações da fatura"
		>
			<InvoiceForm
				invoice={invoice}
				onSubmit={handleSubmit}
				isLoading={updateMutation.isPending}
			/>
		</ResponsiveDialog>
	);
}
