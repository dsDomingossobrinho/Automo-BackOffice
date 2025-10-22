import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

export interface FilterField {
  name: string;
  label: string;
  type: "text" | "select";
  placeholder?: string;
  icon?: string;
  options?: Array<{ value: string; label: string }>;
}

export interface TableFiltersProps {
  fields: FilterField[];
  values: Record<string, string | number | undefined>;
  onChange: (name: string, value: string | undefined) => void;
  onClear: () => void;
  className?: string;
}

export function TableFilters({
  fields,
  values,
  onChange,
  onClear,
  className = "",
}: Readonly<TableFiltersProps>) {
  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    onChange(name, value || undefined);
  };

  const handleSelectChange = (name: string) => (value: string) => {
    // Se o valor for vazio ou undefined, passa undefined para limpar o filtro
    onChange(name, value === "" ? undefined : value);
  };

  return (
    <div className={`mb-6 rounded-lg border bg-card p-4 ${className}`}>
      <div className="flex flex-wrap items-end gap-4">
        {fields.map((field) => (
          <div key={field.name} className="flex-1 min-w-[200px]">
            <label
              htmlFor={field.name}
              className="mb-2 flex items-center gap-2 text-sm font-medium text-foreground"
            >
              {field.icon && <i className={field.icon} />} {field.label}
            </label>

            {field.type === "text" && (
              <Input
                id={field.name}
                name={field.name}
                value={String(values[field.name] || "")}
                onChange={handleInputChange}
                placeholder={field.placeholder}
                className="w-full"
              />
            )}

            {field.type === "select" && field.options && (
              <Select
                value={values[field.name] ? String(values[field.name]) : undefined}
                onValueChange={handleSelectChange(field.name)}
              >
                <SelectTrigger className="w-full">
                  <SelectValue placeholder={field.placeholder || "Todos"} />
                </SelectTrigger>
                <SelectContent>
                  {field.options.map((option) => (
                    <SelectItem key={option.value} value={option.value}>
                      {option.label}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            )}
          </div>
        ))}

        <Button
          type="button"
          variant="secondary"
          onClick={onClear}
          className="mb-0"
        >
          <i className="fas fa-redo mr-2" />{" "}
          Limpar
        </Button>
      </div>
    </div>
  );
}
