export default {
  namespace: true,
  state: {
    faqs: [
      {
        id: 1,
        question: `Làm thế nào để tôi đặt hàng qua website SyncVi?`,
        answer: `Để đặt hàng quá khách tham khảo chi tiết tại <a target="_blank" href="http://ali33.ga/guide-order-shopping">đây</a>`
      },
      {
        id: 2,
        question: `SyncVi có xác nhận đơn hàng với tôi không?`,
        answer: `Sau khi quý khách đặt hàng SyncVi sẽ gọi điện cho bạn để xác nhận cũng như kiểm tra lại thông tin từ quý khách. SyncVi sẽ tiếp nhận và xử lý đơn hàng trong thời gian nhanh nhất.`
      },
      {
        id: 3,
        question: `SyncVi hỗ trợ giao hàng trong bao lâu?`,
        answer: `Chúng tôi sẽ hỗ trợ giao hàng sớm nhất có thể trong khoảng 8 - 10 ngày kể từ khi quý khách đặt cọc.`
      },
      {
        id: 4,
        question: `SyncVi có liên hệ trước khi giao hàng không?`,
        answer: `Bộ phận giao hàng của SyncVi hoặc Đối tác giao hàng của SyncVi sẽ liên hệ trực tiếp với quý khách trước khi giao hàng khoảng 10 - 15 phút.
        Trong trường hợp nỗ lực giao hàng trong ngày chưa thành công, SyncVi sẽ gởi thông báo đến quý khách qua email và hẹn thời gian giao hàng tiếp theo.`
      }
    ]
  },
  getters: {
    getFaqs (state) {
      if (state.faqs.length !== 0) {
        return state.faqs
      }

      return []
    }
  }
}
