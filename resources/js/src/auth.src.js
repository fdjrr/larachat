export const login = async (data) => {
    try {
        const response = await axios.post(`/api/v1/auth/login`, data);

        return response.data;
    } catch (error) {
        return error.response.data;
    }
};
