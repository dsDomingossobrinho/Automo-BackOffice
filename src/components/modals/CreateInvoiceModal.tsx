import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { useCreateInvoice } from "@/hooks/useInvoices";
import type { CreateInvoiceData } from "@/types";
import InvoiceForm from "../forms/InvoiceForm";

interface CreateInvoiceModalProps {
	isOpen: boolean;
	onClose: () => void;
	onSuccess?: (message: string) => void;
	onError?: (message: string) => void;
}

/**
 * Create Invoice Modal
 * Modal para criar nova fatura usando ResponsiveDialog
 */
export default function CreateInvoiceModal({
	isOpen,
	onClose,
	onSuccess,
	onError,
}: Readonly<CreateInvoiceModalProps>) {
	const createMutation = useCreateInvoice();

	const handleSubmit = async (data: CreateInvoiceData) => {
		try {
			await createMutation.mutateAsync(data);
			onSuccess?.("Fatura criada com sucesso!");
			onClose();
		} catch (error: unknown) {
			const message =
				error instanceof Error ? error.message : "Erro ao criar fatura";
			onError?.(message);
		}
	};

	return (
		<ResponsiveDialog
			open={isOpen}
			onOpenChange={(open) => {
				if (!open && !createMutation.isPending) {
					onClose();
				}
			}}
			title="Nova Fatura"
			description="Preencha os dados para criar uma nova fatura"
		>
			<InvoiceForm
				onSubmit={handleSubmit}
				isLoading={createMutation.isPending}
			/>
		</ResponsiveDialog>
	);
}
