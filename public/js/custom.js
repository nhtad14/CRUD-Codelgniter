$(document).ready(function () {
	//datatable
	$(document).ready(function () {
		//datatables
		$("#tblUser").DataTable({
			processing: true, //Feature control the processing indicator.
			serverSide: true, //Feature control DataTables' server-side processing mode.
			order: [], //Initial no order.

			ajax: {
				url: "http://project.test/ajax_list",
				type: "POST",
			},

			columnDefs: [
				{
					targets: [0], //first column / numbering column
					orderable: false, //set not orderable
				},
			],
		});
	});

	//click modal
	$("body").on("click", ".showModal", function () {
		$("#modalProduct").modal("show");
		let id = $(this).attr("data-id"); // gán giá trị id = btn của form
		if (!id) {
			$(".error").remove(); // Xóa data class .error
			$("#formProject")[0].reset(); // reset các input của form
			$(".modal-title").text("Create Product"); // thay đổi text
		} else {
			$(".modal-title").text("Edit Product");
			$.ajax({
				url: "http://project.test/GetProduct/" + id,
				type: "POST",
				dataType: "JSON",
			}).done(function (response) {
				$(".error").remove();
				console.log(response);
				if (response) {
					$.each(response, function (i, item) {
						// for giá trị
						$('[name="' + i + '"]').val(item);
					});
				}
			});
		}
	}),
		// save create + update
		$("body").on("click", ".saveItem", function () {
			let id = $('input[name="id_products"]').val(); // lấy giá trị từ input id
			let url;
			if (!id) {
				url = "http://project.test/addItem";
			} else {
				url = "http://project.test/UpdateProduct/" + id;
			}
			$.ajax({
				url: url,
				type: "POST",
				dataType: "JSON",
				data: $("#formProject").serialize(), // dữ liệu lấy từ form
			}).done(function (response) {
				$(".error").remove();
				console.log(response);
				if (response.status === "success") {
					// khi thêm thành công thì ẩn modal đi
					$("#modalProduct").modal("hide");
					toastr.success(response.massage); // toastr massage
					$("#tblUser").DataTable().ajax.reload();
					$("#formProject")[0].reset();
				} else {
					$.each(response.errors, function (i, item) {
						$('[name="' + i + '"]').after(
							'<span class="error">' + item + "</span>"
						);
					});
				}
			});
		}),
		//DeleteProducts
		$("body").on("click", ".DeleteProduct", function () {
			var id = $(this).data("id");
			$.ajax({
				url: "http://project.test/DeleteProduct/" + id,
				type: "POST",
				dataType: "JSON",
				success: function (data) {
					toastr.success(data.massage);
					$("#tblUser").DataTable().ajax.reload();
				},
				fail: function (jqXHR, textStatus, errorThrown) {
					alert("Xóa sản phẩm thất bại!");
				},
			});
		});
});
