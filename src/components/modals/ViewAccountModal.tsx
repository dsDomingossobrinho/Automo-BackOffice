import {
	Calendar,
	Check,
	Info,
	Mail,
	Phone,
	Shield,
	User,
	X,
} from "lucide-react";
import { ResponsiveDialog } from "@/components/common/responsive-dialog";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Badge } from "@/components/ui/badge";
import { Separator } from "@/components/ui/separator";
import type { Account } from "@/types";
import { PermissionLabels, RoleLabels } from "@/types";

interface ViewAccountModalProps {
	isOpen: boolean;
	onClose: () => void;
	account: Account | null;
}

/**
 * View Account Modal
 * Modal de visualização de detalhes da conta usando ResponsiveDialog
 */
export default function ViewAccountModal({
	isOpen,
	onClose,
	account,
}: Readonly<ViewAccountModalProps>) {
	if (!account) return null;

	const formatDate = (dateString: string) => {
		return new Date(dateString).toLocaleDateString("pt-PT", {
			day: "2-digit",
			month: "long",
			year: "numeric",
		});
	};

	// Get status badge variant
	const getStatusVariant = (
		status: string,
	): "default" | "secondary" | "destructive" | "outline" => {
		const variants: Record<string, "default" | "secondary" | "destructive"> = {
			active: "default",
			inactive: "secondary",
			suspended: "destructive",
			pending: "secondary",
		};
		return variants[status] || "outline";
	};

	// Get status label
	const getStatusLabel = (status: string) => {
		const labels: Record<string, string> = {
			active: "Ativa",
			inactive: "Inativa",
			suspended: "Suspensa",
			pending: "Pendente",
		};
		return labels[status] || status;
	};

	return (
		<ResponsiveDialog
			open={isOpen}
			onOpenChange={onClose}
			title="Detalhes da Conta"
			description={`@${account.username}`}
		>
			<div className="space-y-6">
				{/* Account Header */}
				<div className="flex items-start gap-4">
					<Avatar className="h-16 w-16">
						<AvatarImage src={account.img} alt={account.name} />
						<AvatarFallback className="bg-primary/10 text-primary">
							<User className="h-8 w-8" />
						</AvatarFallback>
					</Avatar>
					<div className="flex-1 space-y-2">
						<div>
							<h3 className="text-lg font-semibold">{account.name}</h3>
							<p className="text-sm text-muted-foreground">
								@{account.username}
							</p>
						</div>
						<Badge variant={getStatusVariant(account.status)}>
							{getStatusLabel(account.status)}
						</Badge>
					</div>
				</div>

				<Separator />

				{/* Account Details */}
				<div className="space-y-4">
					<h4 className="flex items-center gap-2 text-sm font-semibold">
						<Info className="h-4 w-4" /> Informações Gerais
					</h4>
					<div className="grid gap-4 sm:grid-cols-2">
						<div className="space-y-1">
							<div className="flex items-center gap-2 text-sm text-muted-foreground">
								<Mail className="h-4 w-4" />
								<span>Email</span>
							</div>
							<p className="text-sm font-medium">{account.email}</p>
						</div>

						<div className="space-y-1">
							<div className="flex items-center gap-2 text-sm text-muted-foreground">
								<Shield className="h-4 w-4" />
								<span>Role</span>
							</div>
							<p className="text-sm font-medium">
								{RoleLabels[account.roleId] || account.roleId}
							</p>
						</div>

						<div className="space-y-1">
							<div className="flex items-center gap-2 text-sm text-muted-foreground">
								<User className="h-4 w-4" />
								<span>BackOffice</span>
							</div>
							<div className="flex items-center gap-1">
								{account.isBackOffice ? (
									<>
										<Check className="h-4 w-4 text-green-600" />
										<span className="text-sm font-medium">Sim</span>
									</>
								) : (
									<>
										<X className="h-4 w-4 text-red-600" />
										<span className="text-sm font-medium">Não</span>
									</>
								)}
							</div>
						</div>

						{account.contact && (
							<div className="space-y-1">
								<div className="flex items-center gap-2 text-sm text-muted-foreground">
									<Phone className="h-4 w-4" />
									<span>Contacto</span>
								</div>
								<p className="text-sm font-medium">{account.contact}</p>
							</div>
						)}

						{account.identify_id && (
							<div className="space-y-1">
								<div className="flex items-center gap-2 text-sm text-muted-foreground">
									<User className="h-4 w-4" />
									<span>NIF</span>
								</div>
								<p className="text-sm font-medium">{account.identify_id}</p>
							</div>
						)}
					</div>
				</div>

				{/* Permissions */}
				{account.permissions && account.permissions.length > 0 && (
					<>
						<Separator />
						<div className="space-y-4">
							<h4 className="flex items-center gap-2 text-sm font-semibold">
								<Shield className="h-4 w-4" /> Permissões
							</h4>
							<div className="flex flex-wrap gap-2">
								{account.permissions.map((permission) => (
									<Badge key={permission} variant="outline">
										{PermissionLabels[permission] || permission}
									</Badge>
								))}
							</div>
						</div>
					</>
				)}

				{/* Timestamps */}
				<Separator />
				<div className="space-y-4">
					<h4 className="flex items-center gap-2 text-sm font-semibold">
						<Calendar className="h-4 w-4" /> Registo
					</h4>
					<div className="grid gap-4 sm:grid-cols-2">
						<div className="space-y-1">
							<div className="text-sm text-muted-foreground">Criada em</div>
							<p className="text-sm font-medium">
								{formatDate(account.createdAt)}
							</p>
						</div>

						{account.lastLogin && (
							<div className="space-y-1">
								<div className="text-sm text-muted-foreground">
									Último Login
								</div>
								<p className="text-sm font-medium">
									{formatDate(account.lastLogin)}
								</p>
							</div>
						)}
					</div>
				</div>
			</div>
		</ResponsiveDialog>
	);
}
