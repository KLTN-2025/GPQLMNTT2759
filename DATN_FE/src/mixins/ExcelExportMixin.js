import * as XLSX from 'xlsx';

export const ExcelExportMixin = {
    methods: {
        exportToExcel(data, columns, fileName) {
            try {
                // Transform data based on columns definition
                const excelData = data.map((item, index) => {
                    const row = { 'STT': index + 1 };

                    columns.forEach(col => {
                        if (typeof col.value === 'function') {
                            row[col.header] = col.value(item);
                        } else {
                            row[col.header] = item[col.value] || '';
                        }
                    });

                    return row;
                });

                // Create workbook
                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.json_to_sheet(excelData);

                // Set column widths
                const colWidths = [{ wch: 5 }]; // STT column
                columns.forEach(col => {
                    colWidths.push({ wch: col.width || 20 });
                });
                ws['!cols'] = colWidths;

                // Add worksheet to workbook
                XLSX.utils.book_append_sheet(wb, ws, 'Data');

                // Save file
                const timestamp = new Date().toISOString().split('T')[0];
                XLSX.writeFile(wb, `${fileName}-${timestamp}.xlsx`);

                this.$toast.success('Đã xuất Excel thành công!');
            } catch (err) {
                console.error('Excel Export Error:', err);
                this.$toast.error('Lỗi khi xuất Excel: ' + err.message);
            }
        }
    }
};
